from collections import Counter
import pandas as pd
import matplotlib.pyplot as plt

def create_profile(nlp, matcher,text,application_subject):
	"""
	This funciton creates a profile of one sample row 
	in the dataset

	:param nlp: nlp load object with phrasematcher already initialized
	:param matcher: Custom PhraseMatcher object
	:param text: Resume/JD text data
	:param application_subject: company/applicant's name 
	:return: returns the particular profile in a dataframe format
	"""	

	# Get the matches from the text
	doc = nlp(text)
	matches = matcher(doc)
	
	# Create a dataframe to return
	d = []
	for match_id, start, end in matches:
		rule_id = nlp.vocab.strings[match_id]  # get the Skill, eg: 'Machine Learning'
		span = doc[start : end]  # get the Sub-skill, eg: 'Regression'
		d.append((rule_id, span.text))
	data = []
	for each,count in Counter(d).items():
		data.append([application_subject,*each,count])
	dataf = pd.DataFrame(data,columns=['Company/Candidate Name','Skill','Sub-skill','Count'])
	return(dataf)


