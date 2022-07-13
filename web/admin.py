from django.contrib import admin

from .models import Post, Section
'''


@admin.register(Post)
class PostAdmin(admin.ModelAdmin):
    list_display = ('title', 'slug', 'status','created_on')
    inlines = [Section]
'''
admin.site.register(Section)

class SectionInline(admin.StackedInline):
    model = Section

@admin.register(Post)
class PostAdmin(admin.ModelAdmin):
    list_display = ('title', 'slug', 'status','created_on')
    inlines = [SectionInline]
