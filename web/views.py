import logging, requests, json, time
import pandas as pd
from django.shortcuts import render
from django.views.generic import TemplateView
from django.shortcuts import redirect
from web.models import Job

class HomeView(TemplateView):
    def __init__(self):
        self.ctx = ''
        self.logger = logging.getLogger('LinkHS')
        self.template_name = 'index.html'

    def get(self, request):
        return render(request, self.template_name)

    def post(self, request):
        try:
            rq = request.POST.dict()
            print(rq)
            if 'job-title' in rq and 'location' in rq:
                print(f"User searched for {rq['job-title']} in {rq['location']}")
                return redirect(f'/search-page?keywords={rq["job-title"]}&location={rq["location"]}')
        except:
            print('oof')
        return render(request, self.template_name)

class SearchView(TemplateView):
    def __init__(self):
        self.ctx = ''
        self.logger = logging.getLogger('LinkHS')
        self.template_name = 'search-page.html'

    def get(self, request):
        keywords = request.GET.get('keywords')
        location = request.GET.get('location')
        jobs = requests.get(f'https://linkhs-job-api.herokuapp.com/search?keywords={keywords}&location={location}')
        alljobs = json.loads(jobs.text)
        
        careerjet = alljobs['careerjet jobs']['jobs'] if 'jobs' in alljobs['careerjet jobs'] else []

        careerjet = pd.DataFrame(careerjet).iloc[::-1]

        careerjet = careerjet.drop(columns=['site', 'salary', 'salary_min', 'salary_max', 'salary_type', 'salary_currency_code', 'description'])

        df_records = careerjet.to_dict('records')

        t = float(time.time())

        job_instances = [Job(
            locations=record['locations'],
            date=record['date'],
            url=record['url'],
            title=record['title'],
            company=record['company'],
            time = t
        ) for record in df_records]

        Job.objects.bulk_create(job_instances)

        jobs = Job.objects.filter(time=t)

        return render(request, self.template_name, {'jobs': jobs})

    def post(self, request):
        return render(request, self.template_name)