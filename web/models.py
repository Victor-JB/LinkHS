from django.db import models
from django.contrib.auth.models import User
from django.contrib.postgres.fields import ArrayField

STATUS = (
    (0,"Draft"),
    (1,"Publish")
)

class Section(models.Model):
    title = models.TextField(blank=True)
    content_format = models.TextField(blank=True)
    image = models.TextField(blank=True)
    content = models.TextField(blank=True)
    post = models.ForeignKey('Post', on_delete=models.CASCADE)

class Post(models.Model):
    title = models.CharField(max_length=200, unique=True)
    slug = models.SlugField(max_length=200, unique=True)
    author = models.ForeignKey(User, on_delete=models.CASCADE,related_name='blog_posts')
    updated_on = models.DateTimeField(auto_now=True)
    created_on = models.DateTimeField(auto_now_add=True)
    header_image = models.TextField(blank=True)
    status = models.IntegerField(choices=STATUS, default=0)

    class Meta:
        ordering = ['-created_on']

    def __str__(self):
        return self.title

class Job(models.Model):
    locations = models.TextField(blank=True)
    date = models.TextField(blank=True)
    url = models.TextField(blank=True) 
    title = models.TextField(blank=True)
    company = models.TextField(blank=True)
    time = models.FloatField(blank=True)
    description = models.TextField(blank=True)