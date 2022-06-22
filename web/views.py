import logging
from django.shortcuts import render
from django.views.generic import TemplateView

class HomeView(TemplateView):
    def __init__(self):
        self.ctx = ''
        self.logger = logging.getLogger('LinkHS')
        self.sort = 'name'
        self.template_name = 'index.html'

    def get(self, request):
        return render(request, self.template_name)

    def post(self, request):
        return render(request, self.template_name)