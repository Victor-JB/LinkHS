import nltk
nltk.download('stopwords')

#from nltk.corpus import stopwords
from pyresparser import ResumeParser
import os
from docx import Document

filed='/content/Debapratim Ghosh.pdf'

try:
    doc = Document()
    with open(filed, 'r') as file:
        doc.add_paragraph(file.read())
    doc.save("text.docx")
    data = ResumeParser('text.docx').get_extracted_data()
    print(data['skills'])
except:
    data = ResumeParser(filed).get_extracted_data()
    print(data['skills'])
