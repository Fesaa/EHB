import os
import json
from langchain.docstore.document import Document
from langchain_community.document_transformers.beautiful_soup_transformer import BeautifulSoupTransformer

def extract(file: str, link: str):
    bs_transformer = BeautifulSoupTransformer()
    with open(file, 'r') as f:
        content = f.read()
        doc = [Document(page_content=content)]
        transformed = bs_transformer.transform_documents(doc, tags_to_extract=["span", "table", "li", "d", "h1", "h2", "h3", "h4", "h5", "p"], unwanted_tags=["a"])
        d = {}
        d["url"] = link
        d["content"] = transformed[0].page_content
        return d

for file in os.listdir("parsed-html"):
    url = 'parsed-html/' + file
    info = extract(url, 'https://www.erasmushogeschool.be/nl/' +  file.replace(".json", ".html").replace('_', '/'))
    json.dump(info, open('./out/' + file.replace(".html", ".json"), 'w'))
