from serpapi import GoogleSearch
import pandas as pd

# query details
search_terms = "accountant"
location = "Chandler, Arizona, United States"

# private key from serpapi.com
api_key = "4f2b258e35612dae667e902fdfdb21fa499e7b31bafa4f87341cd5cb1ad788d2"

# search parameters
params = {
    "engine": "google_jobs",
    "q": search_terms,
    "location": location,
    "api_key": api_key
}

# connect to Google Jobs API
client = GoogleSearch(params)
results = client.get_dict()

# create df from results
jobs_df = pd.DataFrame(results['jobs_results'])[['title', 'company_name', 'description']]

# write to csv
jobs_df.to_csv("google_jobs.csv")