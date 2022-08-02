import pandas as pd
import spacy
from func import *
from constants import *
from init_parser import init_parser_func
from tqdm import tqdm

nlp = spacy.load('en_core_web_sm')


if __name__ == '__main__':
	
	matcher = init_parser_func(nlp, SKILL_FILE_PATH, file_type="excel")
	
	final_database = pd.DataFrame()
	df = pd.read_excel(DATA_PATH)
	

	for each in tqdm(range(len(df))):

		text = df.loc[each,'Text']
		application_subject = df.loc[each,'Company']
		data = create_profile(nlp,matcher,text,application_subject)
		final_database = final_database.append(data)
    
    
final_agg_sub=pd.DataFrame(final_database.groupby('Company/Candidate Name')['Sub-skill'].apply(list))
final_agg_sub.reset_index(inplace=True)
final_agg_sup=pd.DataFrame(final_database.groupby('Company/Candidate Name')['Skill'].apply(list))
final_agg_sup.reset_index(inplace=True)
output_df=final_agg_sup.merge(final_agg_sub, how='left')
    
output_df['Skill']=output_df.Skill.apply( lambda x : ",".join(x))
output_df['Sub-skill']=output_df['Sub-skill'].apply( lambda x : ",".join(x))


	# Saving the database
output_df.to_csv('../output/Data.csv', index=False)





