from django.contrib import admin
from web.models import Servers, SSHKey, Records, Metrics, TempChartAPI

admin.site.site_header = 'LinkHS'

admin.site.register(SSHKey)
