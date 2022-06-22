from django import template

register = template.Library()

@register.filter(name='split')
def split(value, key):
    '''
        Returns the value turned into a list.
    '''
    return value.split(key)


@register.filter(name='utcify')
def utcify(value, key):
    '''
        Hour and minute turned into utc time expression in string form.
    '''
    hour = str(value)
    minute = str(key)
    if len(hour) == 1:
        hour = '0' + hour
    if len(minute) == 1:
        minute = '0' + minute
    t = hour + ':' + minute
    return t


@register.filter(name='pdtify')
def pdtify(value, key):
    '''
        Hour and minute turned into pdt time expression in string form.
    '''
    hour = str((int(value) + 17) % 24)
    minute = str(key)
    if len(hour) == 1:
        hour = '0' + hour
    if len(minute) == 1:
        minute = '0' + minute
    t = hour + ':' + minute
    return t


@register.filter(name='dayify')
def dayify(value):
    '''
        Pretty up the day format from the wcron.
    '''
    new = ''
    i = 0
    while i < len(value):
        new += value[i] + value[i + 1:i + 3].lower() + ', '
        i += 3
    new = new[0:-2]
    return new