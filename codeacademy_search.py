from selenium import webdriver
from selenium.webdriver.chrome.service import Service as ChromeService
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def find_courses(search_terms):

    # initialize list
    course_list = []

    # construct url
    base_url = "https://www.codecademy.com/search?query="
    query_url = "%20".join(search_terms.split())
    full_url = base_url + query_url

    # initialize webdriver
    options = webdriver.ChromeOptions()
    options.add_argument('headless')
    service = ChromeService(executable_path = ChromeDriverManager().install())

    with webdriver.Chrome(service = service, options = options) as driver:
        
        # load webpage
        driver.get(full_url)

        # wait until results are loaded
        results_list = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.TAG_NAME, "ol"))
        )

        # find courses
        courses = results_list.find_elements(By.TAG_NAME, 'li')
        for course in courses:

            # extract details
            url = course.find_element(By.TAG_NAME, 'a').get_attribute("href")
            title = course.find_element(By.TAG_NAME, 'h3').text
            description = course.find_element(By.XPATH, "a/div/div/span[2]").text

            # add course details to list
            course_list.append(
                {
                    'title': title, 
                    'description': description,
                    'url': url
                }
            )

    return course_list

# print(find_courses("python machine learning"))