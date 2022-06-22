import datetime as dt
import json
import logging
import os
import re
import sys
import threading
from collections import defaultdict
from datetime import datetime, timedelta
from difflib import get_close_matches

import requests
from atlas.services.aws import AWS
from atlas.services.batch_ops import BatchOps
from atlas.services.cloudflare import Cloudflare
from atlas.settings import ATLAS_API_TOKEN, ATLAS_METRICS_URL, USED_REGIONS
from django.shortcuts import render
from django.utils import timezone
from django.views.decorators.csrf import csrf_exempt
from django.views.generic import TemplateView
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response
from rest_framework.views import APIView

from web.models import Metrics, Servers, TempChartAPI

base_dir = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(base_dir)

def natural_name_keys(server):
    '''
    Helper function for natural/human sorting server names.
    '''
    name = server.name.split('.')[0]

    def consider(name):
        return int(name) if name.isdigit() else name
    sorted_list = [consider(c) for c in re.split(r'(\d+)', name)]
    return sorted_list

def natural_id_keys(server):
    '''
    Helper function for natural/human sorting server ids.
    '''
    server_id = server.id

    def consider(server_id):
        return int(server_id) if server_id.isdigit() else server_id
    sorted_list = [consider(c) for c in re.split(r'(\d+)', server_id)]
    return sorted_list

def server_sorter(servers, sortby):
    '''
    Helper function for sorting servers by an attribute.
    '''
    if sortby == 'name': 
        servers.sort(key=natural_name_keys)
    if sortby == 'id': 
        servers.sort(key=natural_id_keys)
    if sortby == 'region':
        regiondict = {}
        for region in USED_REGIONS:
            regiondict[region] = []
        for server in servers:
            regiondict[server.region].append(server)
        servers_by_region = list(regiondict.values())
        servers = []
        for regionlist in servers_by_region:
            regionlist.sort(key=natural_name_keys)
            servers.extend(regionlist)

class ServerView(TemplateView):
    def __init__(self):
        self.aws = AWS()
        self.cloudflare = Cloudflare()
        self.template_name = 'index.html'
        self.ctx = ''
        self.logger = logging.getLogger('atlas')

    def get(self, request):
        return render(request, self.template_name, {'servers': Servers.objects.all(), 'ctx': self.ctx})

    @csrf_exempt
    def post(self, request):
        try:
            id = request.POST.get('id')
            server = Servers.objects.get(id=id)
            if request.POST.get('action') == 'start':
                server.start()
                self.aws.update_all_ec2_instances()
                self.ctx = f'Instance {id} started.'
            elif request.POST.get('action') == 'stop':
                server.stop()
                self.aws.update_all_ec2_instances()
                self.ctx = f'Instance {id} stopped.'
            elif request.POST.get('action') == 'restart':
                server.restart()
                self.aws.update_all_ec2_instances()
                self.ctx = f'Instance {id} restarted.'
            elif request.POST.get('action') == 'update_details':
                self.aws.update_all_ec2_instances()
                self.cloudflare.update_cloudflare_records()
                self.ctx = 'Instance details updated.'
            else:
                self.ctx = 'Invalid action.'
        except Exception as e:
            self.logger.error(f'Error: {e}')
            self.ctx = e
        finally:
            return render(request, self.template_name, {'servers': Servers.objects.all(), 'ctx': self.ctx})

class BatchOpsView(TemplateView):
    def __init__(self):
        self.batch_ops = BatchOps()
        self.template_name = 'batch_ops.html'
        self.results = [{'host': 'Host', 'output': ['No Info to Display']}]
        self.prev = {'boxes': [], 'command': ''}
        self.logger = logging.getLogger('atlas')

    def get(self, request):
        running_servers = [server for server in Servers.objects.all() if server.state == 'running']
        first_col_servers = [running_servers[i] for i in range(len(running_servers)) if i % 2 == 0]
        second_col_servers = [running_servers[i] for i in range(len(running_servers)) if i % 2 == 1]
        return render(request, self.template_name, {'servers': Servers.objects.all(), 'first_col_servers': first_col_servers, 'second_col_servers': second_col_servers, 'results': self.results, 'prev': self.prev})

    # Request sends a list in JSON with the following format:
    '''
    "targets": [
        {
            "name": str (name of the instance used to get corresponding values from db),
        }..,
    ]
    '''
    # Key filenames should be provided by the backend to the frontend
    @csrf_exempt
    def post(self, request):
        try:
            ec2s = json.loads(request.POST.get('targets'))
            host_ips, host_names, users, priv_keys = ([] for _ in range(4))
            for ec2 in ec2s:
                host_ip = Servers.objects.get(name=ec2['name']).public_ip
                host_name = Servers.objects.get(name=ec2['name']).name
                ec2_user = Servers.objects.get(name=ec2['name']).username
                host_ips.append(host_ip)
                host_names.append(host_name)
                users.append(ec2_user)
                try:
                    ssh_key = Servers.objects.get(name=ec2['name']).ssh_key
                    priv_keys.append(ssh_key.file.path)
                except Exception as e:
                    self.logger.error(f'Error retrieving SSH Key for {ec2_user}@{host_name}: {e}, command not run')
                    ssh_key = None
                    priv_keys.append(ssh_key)
            self.results = self.batch_ops.run_batch_ops(host_ips, host_names, users, priv_keys, request.POST.get('command'))
        except Exception as e:
            self.logger.error(f'Error: {e}')
            self.results = [{'host': 'Host', 'output': [f'Error: {e}']}]
        finally:
            self.prev = request.POST.get('prev')
            running_servers = [server for server in Servers.objects.all() if server.state == 'running']
            first_col_servers = [running_servers[i] for i in range(len(running_servers)) if i % 2 == 0]
            second_col_servers = [running_servers[i] for i in range(len(running_servers)) if i % 2 == 1]
            return render(request, self.template_name, {'servers': Servers.objects.all(), 'first_col_servers': first_col_servers, 'second_col_servers': second_col_servers, 'results': self.results, 'prev': self.prev})

class ServerApiView(APIView):
    def __init__(self):
        self.permission_classes = [IsAuthenticated]
        self.aws = AWS()
        self.cloudflare = Cloudflare()
        self.logger = logging.getLogger('atlas')
        self.ctx = ''

    def get(self, request, query):
        if query.split('-')[0] == 'charts':
            offset = query.split('-')[3]
            if TempChartAPI.objects.get(id=int(offset)).info:
                chart_content = json.loads(TempChartAPI.objects.get(id=int(offset)).info)
                instance_content = [[], [], []]
                for i in range(len(chart_content)):
                    try:
                        instance_content = chart_content[i][f"{query.split('-')[1]}-{query.split('-')[2]}"]
                        break
                    except KeyError:
                        pass
                return Response(json.dumps(instance_content))

            return Response(json.dumps([[], [], []]))

        try:
            self.requested_data = [getattr(server, query) for server in Servers.objects.all()]
            self.debug_info = None
        except Exception as e:
            self.requested_data = None
            self.debug_info = e

        content = {
            'user': str(request.user),
            'auth': str(request.auth),
            query: self.requested_data,
            'debug': str(self.debug_info)
        }
        return Response(content)
            
    def regex_find_servers(self, expression):
        '''
        Takes a regex expression and returns a list of server ids that match
        '''
        ids = []
        for region in USED_REGIONS:
            response = self.aws.describe_instances(region=region)
            for reservation in response.get('Reservations'):
                for instance in reservation.get('Instances'):
                    for tag in instance.get('Tags'):
                        if tag.get('Key') == 'Name':
                            if re.search(expression, tag.get('Value')):
                                ids.append(instance.get('InstanceId'))
        return Servers.objects.filter(id__in=ids)
    
    def batch_start_servers(self, servers):
        threads = []
        if any(server.state != 'stopped' for server in servers):
            # Feedback for discord bot, it splits by newline 3 times, so there cannot be more than 3 lines
            raise Exception('❌ Server already running\n***Note:*** *After stopping a server, you will be unable to start it for a few minutes. If it has been more than 15 minutes and you still cannot start it, open a ticket in #tech-support*\nBe mindful of others who may be using this server, do not interrupt their work!')
        for server in servers:
            thread = threading.Thread(target=server.start)
            threads.append(thread)
        for _ in threads:
            _.start()
        for _ in threads:
            _.join()
        self.cloudflare.update_cloudflare_records()
        self.aws.update_all_ec2_instances()

    def batch_stop_servers(self, servers):
        threads = []
        if any(server.state != 'running' for server in servers):
            # Feedback for discord bot, it splits by newline 3 times, so there cannot be more than 3 lines
            raise Exception('❌ Server already stopped\n***Note:*** *After starting/restarting a server, you will be unable to stop it for a few minutes. If it has been more than 15 minutes and you still cannot stop it, open a ticket in #tech-support*\nBe mindful of others who may be using this server, do not interrupt their work!')
        if not any(server.launch_time < datetime.now().astimezone(dt.timezone.utc) - timedelta(minutes=10) for server in servers):
            # Feedback for discord bot, it splits by newline 3 times, so there cannot be more than 3 lines
            raise Exception('❌ Server has not been running for more than 10 minutes, cannot stop this quickly!\n***Note:*** *After starting/restarting a server, you will be unable to stop it for a few minutes. If it has been more than 15 minutes and you still cannot stop it, open a ticket in #tech-support*\nBe mindful of others who may be using this server, do not interrupt their work!')
        for server in servers:
            thread = threading.Thread(target=server.stop)
            threads.append(thread)
        for _ in threads:
            _.start()
        for _ in threads:
            _.join()
        self.aws.update_all_ec2_instances()
        
    def batch_restart_servers(self, servers):
        threads = []
        if any(server.state != 'running' for server in servers):
            # Feedback for discord bot, it splits by newline 3 times, so there cannot be more than 3 lines
            raise Exception('❌ Server cannot be restarted right now\n***Note:*** *After starting a server, you will be unable to restart it for a few minutes. If it has been more than 15 minutes and you still cannot restart it, open a ticket in #tech-support*\nBe mindful of others who may be using this server, do not interrupt their work!')
        if not any(server.launch_time < datetime.now().astimezone(dt.timezone.utc) - timedelta(minutes=10) for server in servers):
            # Feedback for discord bot, it splits by newline 3 times, so there cannot be more than 3 lines
            raise Exception('❌ Server has not been running for more than 10 minutes, cannot restart this quickly!\n***Note:*** *After starting a server, you will be unable to restart it for a few minutes. If it has been more than 15 minutes and you still cannot stop it, open a ticket in #tech-support*\nBe mindful of others who may be using this server, do not interrupt their work!')
        for server in servers:
            thread = threading.Thread(target=server.restart)
            threads.append(thread)
        for _ in threads:
            _.start()
        for _ in threads:
            _.join()
        self.aws.update_all_ec2_instances()

    def post(self, request, query):
        if query == 'charts':
            offset = request.headers['offset']
            chart_content, _ = TempChartAPI.objects.get_or_create(id=int(offset))
            chart_content.info = request.body.decode("utf-8")
            chart_content.save()
            return Response(TempChartAPI.objects.get(id=int(offset)).info)

        success = True
        try:
            ids = request.POST.get('ids')
            if ids:
                ids = ids.split(',')
            if query == 'start':
                expression = request.POST.get('expression')
                if expression:
                    self.logger.info(f'Regex expression recieved: {expression}')
                    servers = self.regex_find_servers(expression)
                    self.logger.info(f'Regex expression matched servers: {[server.name for server in servers]}')
                else:
                    servers = Servers.objects.filter(id__in=ids)
                self.batch_start_servers(servers)
                self.ctx = f'Instances {[server.name for server in servers]} started.'
            elif query == 'stop':
                expression = request.POST.get('expression')
                if expression:
                    self.logger.info(f'Regex expression recieved: {expression}')
                    servers = self.regex_find_servers(expression)
                    self.logger.info(f'Regex expression matched ids: {[server.name for server in servers]}')
                else:
                    servers = Servers.objects.filter(id__in=ids)
                self.batch_stop_servers(servers)
                self.ctx = f'Instances {[server.name for server in servers]} stopped.'
            elif query == 'restart':
                expression = request.POST.get('expression')
                if expression:
                    self.logger.info(f'Regex expression recieved: {expression}')
                    servers = self.regex_find_servers(expression)
                    self.logger.info(f'Regex expression matched ids: {[server.name for server in servers]}')
                else:
                    servers = Servers.objects.filter(id__in=ids)
                self.batch_restart_servers(servers)
                self.ctx = f'Instances {[server.name for server in servers]} restarted.'
            elif query == 'update':
                self.aws.update_all_ec2_instances()
                self.cloudflare.update_cloudflare_records()
                self.ctx = 'Instances updated.'
            elif query == 'closest':
                server_name = request.POST.get('server_name')
                all_server_names = [server.name for server in Servers.objects.all()]
                try:
                    closest_server_name = f'Maybe you meant `{get_close_matches(server_name, all_server_names, 1)[0]}`?'
                    self.logger.debug(f'Closest server name to {server_name} is: {closest_server_name}')
                except Exception as e:
                    success = False
                    closest_server_name = 'No close matches found to the provided server name either.'
                    self.logger.debug(f'No close match found for {server_name}: {e}')
                self.ctx = closest_server_name
            else:
                self.ctx = 'Invalid action.'
                success = False
        except Exception as e:
            self.logger.error(f'Error: {e}')
            self.ctx = str(e) # e is an Exception object by default and is not serializable
            success = False
        content = {
            'ctx': self.ctx,
            'success': success
        }
        return Response(content)

class AutoStartView(TemplateView):
    def __init__(self):
        self.aws = AWS()
        self.cloudflare = Cloudflare()
        self.template_name = 'auto_start.html'
        self.ctx = ''
        self.logger = logging.getLogger('atlas')
        self.sort = 'name'

    def get(self, request):
        self.logger.debug(self.sort)
        used_servers = []
        for region in USED_REGIONS:
            used_servers += self.aws.get_lambda_servers(region)
        unused_servers = []
        for region in USED_REGIONS:
            unused_servers += self.aws.get_not_scheduled(region)
        
        unused_servers.sort(key=natural_name_keys)

        server_sorter(used_servers, self.sort)

        return render(request, self.template_name, {'servers': used_servers, 'ctx': self.ctx, 'unused_servers': unused_servers})

    @csrf_exempt
    def post(self, request):
        try:
            rq = request.POST.dict()
            if 'addservers' in rq:
                unused_servers = []
                for region in USED_REGIONS:
                    unused_servers += self.aws.get_not_scheduled(region)
                server_id = rq['addservers']
                unused_ids = []

                for i in unused_servers:
                    unused_ids.append(i.id)
                if server_id not in unused_ids:
                    self.logger.error('Could not find server.')
                    self.ctx = 'Could not find server.'
                else:
                    region = Servers.objects.get(id=server_id).region
                    self.aws.setup_auto_start(server_id, region)
                    self.ctx = 'Instance added to auto start.'
            
            elif 'remove' in rq:
                used_servers = []
                for region in USED_REGIONS:
                    used_servers += self.aws.get_lambda_servers(region)
                server_id = rq['remove']
                used_ids = []
                for i in used_servers:
                    used_ids.append(i.id)

                if server_id not in used_ids:
                    self.logger.error('Could not find server.')
                    self.ctx = 'Could not find server.'
                else:
                    region = Servers.objects.get(id=server_id).region
                    self.aws.autostart_deleter(rq['remove'], region)
                    self.aws.update_event_rules(server_id, region)
                    self.ctx = 'Removed!'

            elif 'removerule' in rq:
                parts = rq['removerule'].split('.')
                ist_id = parts[0]
                wcron = parts[1]
                region = Servers.objects.get(id=ist_id).region
                self.aws.event_deleter(ist_id, wcron, region)
                self.aws.update_event_rules(ist_id, region)
                self.ctx = 'Deleted Rule!'

            elif 'time' in rq:
                time = str(rq['time'])
                days = []
                for k in rq.keys():
                    if len(k) > 3 and k[0:3] == 'day':
                        days.append(int(k[3]))
                days.sort()
                if len(days) != 0:
                    hour = int(time.split(':')[0])
                    hour = (hour + 7) % 24
                    minute = int(time.split(':')[1])
                    ist_id = rq['ist_id']
                    region = Servers.objects.get(id=ist_id).region
                    self.aws.schedule_auto_start(ist_id, days, hour, minute, region)
                    self.aws.update_event_rules(ist_id, region)
                else:
                    self.ctx = 'No days input.'
            
            elif 'timebulk' in rq:
                time = str(rq['timebulk'])

                days = []
                servers = []
                for k in rq.keys():
                    if len(k) > 7 and k[0:7] == 'bulkday':
                        days.append(int(k[7]))

                    if len(k) == 19 and k[0:2] == 'i-':
                        servers.append(k)
                days.sort()
                if len(days) == 0:
                    self.ctx = 'No days input.'
                elif len(servers) == 0:
                    self.ctx = 'No servers input.'
                else:
                    hour = int(time.split(':')[0])
                    hour = (hour + 7) % 24
                    minute = int(time.split(':')[1])
                    for server in servers:
                        region = Servers.objects.get(id=server).region
                        self.aws.schedule_auto_start(server, days, hour, minute, region)
                        self.aws.update_event_rules(server, region)
                    self.ctx = 'Scheduled!'
            
            elif 'sortname' in rq:
                self.sort = 'name'
            elif 'sortid' in rq:
                self.sort = 'id'
            elif 'sortregion' in rq:
                self.sort = 'region'

            else:
                self.ctx = 'Invalid action.'

        except Exception as e:
            self.logger.error(f'Error: {e}')
            self.ctx = e
        finally:
            used_servers = []
            for region in USED_REGIONS:
                used_servers += self.aws.get_lambda_servers(region)
            unused_servers = []
            for region in USED_REGIONS:
                unused_servers += self.aws.get_not_scheduled(region)
            
            unused_servers.sort(key=natural_name_keys)
            server_sorter(used_servers, self.sort)

            return render(request, self.template_name, {'servers': used_servers, 'ctx': self.ctx, 'unused_servers': unused_servers})

class MetricsView(TemplateView):
    def __init__(self):
        self.template_name = 'metrics.html'
        self.logger = logging.getLogger('atlas')

        self.time_range = timedelta(hours=48) # default time range for base metrics
        self.headers = {'Authorization': f'Token {ATLAS_API_TOKEN}', 'Content-Type': 'application/json'}
        self.url = ATLAS_METRICS_URL
        self.offset = 1

        self.page_header = 'Welcome to Server Metrics'
        self.ctx = ''

    def get(self, request):
        initial_filtered_set = Metrics.objects.filter(created_at__range=[timezone.now() - self.time_range, timezone.now()])
        interval_metrics = []

        for instance in initial_filtered_set.values('server_id').distinct():
            first_time = True
            for metric in initial_filtered_set:
                if metric.server_id == instance['server_id']:
                    if first_time:
                        prev_metric = metric
                        first_time = False
                        continue
                    if metric.created_at - prev_metric.created_at > timedelta(seconds=59): # spacing between metrics
                        interval_metrics.append(metric.id)
                    prev_metric = metric

        filtered_set = initial_filtered_set.filter(id__in=interval_metrics)

        id_sets = {}
        for unique_id in filtered_set.values('server_id').distinct():
            id_sets[unique_id['server_id']] = filtered_set.filter(server_id=unique_id['server_id'])

        id_base_data = []
        for key in id_sets:
            all_user_names = []
            for row in id_sets[key]:
                for name in json.loads(row.user_names):
                    all_user_names.append(name)
            total_users = len(set(all_user_names))
            if len(all_user_names) != 0:
                top_user = max(set(all_user_names), key=all_user_names.count)
            else:
                top_user = 'None'
            id_base_data.append({'id': key,
                                 'name': Servers.objects.get(id=key).name,
                                 'state': Servers.objects.get(id=key).state,
                                 'cpu_util': Servers.objects.get(id=key).cpu_util,
                                 'total_users': total_users,
                                 'top_user': top_user})

        sorted_id_base_data = list(sorted(id_base_data, key=lambda item: item['total_users'], reverse=True))

        def split_by_offset(values, n):
            k, m = divmod(len(values), n)
            return (values[i * k + min(i, m):(i + 1) * k + min(i + 1, m)] for i in range(n))

        chart_data = filtered_set.values('server_id', 'cpu_util', 'num_users', 'created_at')
        output_chart_data = defaultdict(list)
        for unique_id in filtered_set.values('server_id').distinct():
            cpu_instance_set = []
            num_users_instance_set = []
            created_at_instance_set = []
            container = []
            for row in chart_data:
                if row['server_id'] == unique_id['server_id']:
                    if row['cpu_util'] == -1.0:
                        cpu_instance_set.append(0.0)
                    else:
                        cpu_instance_set.append(row['cpu_util'])
                    num_users_instance_set.append(row['num_users'])
                    created_at_instance_set.append(str(row['created_at']).split('+')[0].split('.')[0][:-3])

            total_size = sys.getsizeof(cpu_instance_set) + sys.getsizeof(num_users_instance_set) + sys.getsizeof(created_at_instance_set)
            divider = 1
            while total_size / divider >= 1000000: # limit byte size for post request supported by nginx
                divider += 1

            split_cpu_instance_set = list(split_by_offset(cpu_instance_set, divider))
            split_num_users_instance_set = list(split_by_offset(num_users_instance_set, divider))
            split_created_at_instance_set = list(split_by_offset(created_at_instance_set, divider))

            for offset in range(divider):
                split_offsets_dict = {}
                split_offsets_dict[unique_id['server_id']] = [split_cpu_instance_set[offset],
                                                              split_num_users_instance_set[offset],
                                                              split_created_at_instance_set[offset]]
                container.append((offset, split_offsets_dict))

            for k, v in container:
                output_chart_data[k].append(v)

            if divider > self.offset:
                self.offset = divider

        for offset in range(self.offset):
            self.headers['offset'] = str(offset + 1)
            response = requests.post(self.url, headers=self.headers, json=output_chart_data[offset])
            if response.status_code != 200:
                self.logger.error(f'Error posting chart vars for offset {offset}, status code: {response.status_code}')

        return render(request, self.template_name, {'servers': sorted_id_base_data, 'ctx': self.ctx, 'header': self.page_header, 'token': ATLAS_API_TOKEN, 'offset': self.offset})

    '''
    Data structure that gets posted to /api/charts
    {0: [{'id0': [[1,1,1], [1,1,1], [date1, date2, date3]]}, {'id1': [[2,2,2], [2,2,2], [date1, date2, date3]]}],
     1: [{'id0': [[1,1,1], [1,1,1], [date4, date5, date6]]}, {'id1': [[2,2,2], [2,2,2], [date4, date5, date6]]}]}
    '''

    def post(self, request):
        initial_filtered_set = Metrics.objects.filter(created_at__range=[timezone.now() - self.time_range, timezone.now()])
        interval_metrics = []

        for instance in initial_filtered_set.values('server_id').distinct():
            first_time = True
            for metric in initial_filtered_set:
                if metric.server_id == instance['server_id']:
                    if first_time:
                        prev_metric = metric
                        first_time = False
                        continue
                    if metric.created_at - prev_metric.created_at > timedelta(seconds=59): # spacing between metrics
                        interval_metrics.append(metric.id)
                    prev_metric = metric

        filtered_set = initial_filtered_set.filter(id__in=interval_metrics)

        id_sets = {}
        for unique_id in filtered_set.values('server_id').distinct():
            id_sets[unique_id['server_id']] = filtered_set.filter(server_id=unique_id['server_id'])

        id_base_data = []
        for key in id_sets:
            all_user_names = []
            for row in id_sets[key]:
                for name in json.loads(row.user_names):
                    all_user_names.append(name)
            total_users = len(set(all_user_names))
            if len(all_user_names) != 0:
                top_user = max(set(all_user_names), key=all_user_names.count)
            else:
                top_user = 'None'
            id_base_data.append({'id': key,
                                 'name': Servers.objects.get(id=key).name,
                                 'state': Servers.objects.get(id=key).state,
                                 'cpu_util': Servers.objects.get(id=key).cpu_util,
                                 'total_users': total_users,
                                 'top_user': top_user})

        sorted_id_base_data = list(sorted(id_base_data, key=lambda item: item['total_users'], reverse=True))

        user_time_range = timedelta(hours=int(request.POST.get('range')))
        user_filtered_set = Metrics.objects.filter(created_at__range=[timezone.now() - user_time_range, timezone.now()])

        def split_by_offset(values, n):
            k, m = divmod(len(values), n)
            return (values[i * k + min(i, m):(i + 1) * k + min(i + 1, m)] for i in range(n))

        chart_data = user_filtered_set.values('server_id', 'cpu_util', 'num_users', 'created_at')
        output_chart_data = defaultdict(list)
        for unique_id in user_filtered_set.values('server_id').distinct():
            cpu_instance_set = []
            num_users_instance_set = []
            created_at_instance_set = []
            container = []
            for row in chart_data:
                if row['server_id'] == unique_id['server_id']:
                    if row['cpu_util'] == -1.0:
                        cpu_instance_set.append(0.0)
                    else:
                        cpu_instance_set.append(row['cpu_util'])
                    num_users_instance_set.append(row['num_users'])
                    created_at_instance_set.append(str(row['created_at']).split('+')[0].split('.')[0][:-3])

            total_size = sys.getsizeof(cpu_instance_set) + sys.getsizeof(num_users_instance_set) + sys.getsizeof(created_at_instance_set)
            divider = 1
            while total_size / divider >= 1000000: # limit byte size for post request supported by nginx
                divider += 1

            split_cpu_instance_set = list(split_by_offset(cpu_instance_set, divider))
            split_num_users_instance_set = list(split_by_offset(num_users_instance_set, divider))
            split_created_at_instance_set = list(split_by_offset(created_at_instance_set, divider))

            for offset in range(divider):
                split_offsets_dict = {}
                split_offsets_dict[unique_id['server_id']] = [split_cpu_instance_set[offset],
                                                              split_num_users_instance_set[offset],
                                                              split_created_at_instance_set[offset]]
                container.append((offset, split_offsets_dict))

            for k, v in container:
                output_chart_data[k].append(v)

            if divider > self.offset:
                self.offset = divider

        for offset in range(self.offset):
            self.headers['offset'] = str(offset + 1)
            response = requests.post(self.url, headers=self.headers, json=output_chart_data[offset])
            if response.status_code != 200:
                self.logger.error(f'Error posting chart vars for offset {offset}, status code: {response.status_code}')

        return render(request, self.template_name, {'servers': sorted_id_base_data, 'ctx': self.ctx, 'header': self.page_header, 'token': ATLAS_API_TOKEN, 'offset': self.offset})
