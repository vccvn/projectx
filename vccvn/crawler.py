import sys
import os
import os.path
import random
import string
import requests
from bs4 import BeautifulSoup
import csv

ENDPOINT = "https://api.webscrapingapi.com/v1/"
API_KEY = "JjvZxHTOWMwJcuZ8Hh9LQLxS53hEByWB"

def get_page_source(url, key = ""):
    k = API_KEY
    if(len(key)>0): 
        k = key
    params = {
        "api_key": k,
        'device': 'desktop',
        # 'proxy_type': 'datacenter',
        # 'country': 'au',
        "url": url,
        "render_js": '1',
        'wait_for': '2',
        'timeout': '60000',
        # 'wait_until': 'networkidle2'
    }
    print(params)
    page = requests.request("GET", ENDPOINT, params=params)
    soup = BeautifulSoup(page.content, 'html.parser')
    body = soup.find('html')

    # file_source = open(filename, mode='w', encoding='utf-8')
    # file_source.write(str(body))
    # file_source.close()

    return str(body)

if __name__ == '__main__':
    if len(sys.argv) > 2 :
        key = API_KEY
        if(len(sys.argv) > 3 and sys.argv[3]):
            key = sys.argv[2]
        content = get_page_source(sys.argv[2], key)

        file_source = open(file = sys.argv[2], mode='w', encoding='utf-8')
        file_source.write(content)
        file_source.close()
        print("crawl success !")
        print("view File: " + sys.argv[2])
    else:
        print("Ban chua nhap content")    
        

        