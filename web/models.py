from django.db import models
from django.db.models.signals import post_delete, post_save
from django.dispatch import receiver

import datetime
import logging
logger = logging.getLogger('atlas')


class SSHKey(models.Model):
    file = models.FileField(upload_to='keys', blank=True, null=True)
    name = models.CharField(max_length=200, primary_key=True)