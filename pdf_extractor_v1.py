# V1

import PyPDF2
import sys


def extract_text_from_pdf(pdf_path):
    text = ""
    with open(pdf_path, 'rb') as pdf_file:
        pdf_reader = PyPDF2.PdfReader(pdf_file)
        for page_num in range(len(pdf_reader.pages)): 
            text += pdf_reader.pages[page_num].extract_text()
    return text

if len(sys.argv) != 2:
    print("Usage: python pdf_extractor_v1.py <pdf_file>")
    sys.exit(1)

pdf_path = sys.argv[1]
extracted_text = extract_text_from_pdf(pdf_path)
print(extracted_text)