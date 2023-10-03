# V2

import textract
import os


def extract_text_from_pdf(pdf_path):
    #use this command to know the path (which pdftotext)
    text = textract.parsers.process(pdf_path,input_encoding='Latin-1')
    return text

pdf_folder = './CVs'

# Output folder for text files
output_folder = './CVs/txt'

for pdf_filename in os.listdir(pdf_folder):
    if pdf_filename.endswith('.pdf'):
        pdf_file_path = os.path.join(pdf_folder, pdf_filename)

        # Extract text from the PDF
        extracted_text = extract_text_from_pdf(pdf_file_path)

        # Create a text file with the same name as the PDF
        text_filename = os.path.splitext(pdf_filename)[0] + '.txt'
        text_file_path = os.path.join(output_folder, text_filename)

        # Write the extracted text to the text file
        with open(text_file_path, 'wb') as text_file:
            text_file.write(extracted_text)
print("done")