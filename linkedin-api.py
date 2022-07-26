import os
import requests as req
from bs4 import BeautifulSoup
import pandas as pd
from linkedin_v2 import linkedin  # sudo pip install python-linkedin-v2
import xmltodict    # sudo pip install xmltodict

# to set up server on user's computer for OAuth 2.0 based authentication and authorzation
# Copy/paste in seperate terminal window below line:
# python3 -m http.server 8000

# Victor's note: not sure if this is actually necessary, haven't run into any
# error indicating that there's a problem instantiating the server :shrug:

#----------------------------Define Functions----------------------------

# create a dataframe of job listings from lists of the titles, companies, locations, and links
def createJobListingsDF(titles,companies,cities,states,links):
    jobDict = {
    'Title':titles,
    'Company':companies,
    'City':cities,
    'State':states,
    'Link':links
    }

    jobListings = pd.DataFrame(jobDict)
    return jobListings

#---------------------------- Using LinkedIn API ----------------------------

# Retrieve job titles with LinkedIn-Get-Job API and job IDs
def get_job_title(job_id):

    # Send request LinkedIn server using OAuth 2.0 based authentication
    url = 'https://api.linkedin.com/v1/job_search?oauth2_access_token=AQVIHZX39PPbvEC9mPzDPTVze3zuZvDp4BFGn9tGfnvb3GKXmgS_AKCRNT_y85nyb8f6HAWLIHIruJM5XVKGo5dAy7cbn5rEq0Zwt63D2D1BnpX-otZVvHvmxL8uJnfQDDeuZuL6sgVF8avXK88PAPJsY7i-qtqqSi35oBNSqWR_sy4oRwc'
    # read url
    file = req.get(url)
    data = file.read()
    file.close()
    # Parse returned xml file
    data = xmltodict.parse(data)
    # Get job titile corresponding to each job ID
    Job_title = data['job']['position']['title']

    return Job_title

def getLinkedinJobs(search_term,start=0):

    # Set token and secret for LinkedIn API - OAuth 1.0

    CONSUMER_KEY = '758bcqo3nipdwk'
    CONSUMER_SECRET = 'mUNd9c51xi5jDtlg'
    USER_TOKEN = 'b86af9a8-1757-42de-a8cc-60acb6f61eb9'
    USER_SECRET = 'af85d9ce-d082-4411-ad3b-1763e07a5ab2'
    RETURN_URL = 'http://localhost:8000'

    # Setup connection with LinkedIn
    authentication = linkedin.LinkedInDeveloperAuthentication(CONSUMER_KEY, CONSUMER_SECRET,
                                                              USER_TOKEN, USER_SECRET,
                                                              RETURN_URL, linkedin.PERMISSIONS.enums.values())

    application = linkedin.LinkedInApplication(authentication)

    print(application.get_connections())

    # get total number of available jobtitles
    total = application.search_jobs(params={'keywords': search_term,
                                           'start':0, 'count': 20, 'country-code':'us'})['numResults']
    # Comment above line and uncomment following line if search for specific job titles
    #total = application.search_job(params={'job-title': 'Data Scientist', 'start':0, 'count': 20, 'country-code':'us'})['numResults']

    job_list = []
    raw_job_list = []

    # Retrieve job informations using LinkedIn Job Search API
    for i in range(0,total+1,20):

        # Retrieve 20 jobs on every call to LinkedIn Job Search API and store in a list
        raw_job_list = application.search_job(params={'keywords': search_term,
                                           'start':0, 'count': 20, 'country-code':'us'})
        # Comment above line and uncomment following line if search for specific job titles
        #raw_job_list = application.search_job(params={'job-title': 'Data Scientist', 'start':i, 'count': 20, 'country-code':'us'})

        # Parse the list containing job information
        for job in raw_job_list['jobs']['values']:
            term = []
            # LinkedIn Job Search API return job ID instead of Job Title
            term.append(job['id'])
            term.append(job['company']['name'])
            # Split location information to City and State
            flag = 0
            if 'locationDescription' in job:
                location = job['locationDescription']
                flag = location.find(',')

                if flag > 0:
                    city = location[0:flag]
                    state = location[flag+2:len(location)]
                if flag < 0:
                    city = location
                    state = ''

                term.append(city)
                term.append(state)

            job_list.append(term)

    for job in job_list:
        job.append(get_job_title(job[0]))

    # Create list containing required information
    titles = [x[4] for x in job_list]
    companies = [x[1] for x in job_list]
    cities = [x[2] for x in job_list]
    states = [x[3] for x in job_list]
    links = ['http://www.linkedin.com/jobs?viewJob=&jobId='+str(x[0]) for x in job_list]

    linkedinJobs = createJobListingsDF(titles,companies,cities,states,links).drop_duplicates()

    return linkedinJobs


# Combine all parts together and output as csv
#-------------------------------------------------------------------------------------------------
def main():
    # Get search terms from user input
    key_words = input("Key Words ---> ")

    search_term_linkedin = key_words                    # Set search terms for LinkedIn APIs


    linkedinJobs = getLinkedinJobs(search_term_linkedin)
    print("LinkedIn jobs: " + str(len(linkedinJobs)))
    linkedinJobs.to_csv('linkedinJobs1.csv')

    allJobs = pd.concat([linkedinJobs], keys=['linkedin.com'])
    print("LinkedIn jobs: " + str(len(allJobs)))

    allJobsRed = allJobs.drop_duplicates(cols=('Title','Company','City','State'))
    print("LinkedIn jobs (no duplicates): " + str(len(allJobsRed)))
    print("Duplicates removed: " + str(len(allJobs)-len(allJobsRed)))

    allJobsRed.to_csv('allJobs1.csv')

if __name__ == "__main__":
    main()
