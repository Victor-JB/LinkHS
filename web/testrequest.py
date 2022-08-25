import requests

x = requests.get('https://linkhs-job-api.herokuapp.com/search?keywords=data%20science&location=arizona')

print(x.text)