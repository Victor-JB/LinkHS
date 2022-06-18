from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import pandas as pd

URL = "https://www.indeed.com/"
SEARCH_TERMS = "high school student part time"

locations = ["San Francisco, CA", "Seattle, WA", "Dallas, TX", "Phoenix, AZ", "Chicago, IL", 
             "Miami, FL", "Atlanta, GA", "Portland, OR", "Denver, CO", "Orlando, FL"]

# initialize webdriver
service = Service(executable_path = ChromeDriverManager().install())
driver = webdriver.Chrome(service = service)

# prepare list and dict
job_urls = []
jobs_dict = {
    "job_title": [], 
    "description": [], 
    "url": [], 
    "location": []
}

# get indeed listings for each location
for location in locations:
    
    # navigate to website
    driver.get(URL)

    # load page and find search bars
    job_search = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "text-input-what"))
    )

    location_search = driver.find_element(By.ID, "text-input-where")

    # search for given terms and location
    job_search.send_keys(SEARCH_TERMS)

    while location_search.get_attribute("value") != "":
        location_search.send_keys(Keys.BACK_SPACE)
    location_search.send_keys(location)
    location_search.send_keys(Keys.ENTER)

    for _ in range(20):

        # find all job listings & prepare to get urls
        job_listings = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CLASS_NAME, "jobTitle"))
        )
        
        # loop through job listings
        for job in job_listings:

            # get url from each job listing
            details = job.find_element(By.TAG_NAME, "a")
            url = details.get_attribute("href")
            job_urls.append(url)

        # navigate to next page
        next_button = driver.find_elements(By.CSS_SELECTOR, "[aria-label=\"Next\"]")
        if len(next_button) == 1:
            next_url = next_button[0].get_attribute("href")
            driver.get(next_url)
        else:
            break # once final page is reached

# loop through job urls
for url in job_urls:
    
    # navigate to url
    driver.get(url)
    
    # get details of job listing
    job_title = driver.find_element(By.TAG_NAME, "h1").text
    salary = driver.find_element(By.CLASS_NAME, "icl-u-xs-mr--xs").text
    description = driver.find_element(By.ID, "jobDescriptionText").text

    # add to dict
    jobs_dict["job_title"].append(job_title)
    jobs_dict["description"].append(description)
    jobs_dict["url"].append(url)
    jobs_dict["location"].append(location)

# close browser
driver.quit()

# convert dict to dataframe
jobs_df = pd.DataFrame().from_dict(jobs_dict)
jobs_df.to_csv("raw_data/indeed.csv", index = False)