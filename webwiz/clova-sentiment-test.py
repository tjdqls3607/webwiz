#!/usr/bin/env python3
#-*- codig: utf-8 -*-
import sys
import requests
import json
client_id = "vqho0hcnrv"
client_secret = "THssQvHRcpHmGhNsEqtOzFGTY7X8KXoFiloePkLm"
url="https://naveropenapi.apigw.ntruss.com/sentiment-analysis/v1/analyze"
headers = {
    "X-NCP-APIGW-API-KEY-ID": client_id,
    "X-NCP-APIGW-API-KEY": client_secret,
    "Content-Type": "application/json"
}
content = "반려견과 함께 산책을 다녀왔다. 푸른 잔디 위에서 뛰어노는 모습이 참 보기 좋았다."
data = {
  "content": content
}
print(json.dumps(data, indent=4, sort_keys=True))
response = requests.post(url, data=json.dumps(data), headers=headers)
rescode = response.status_code
if(rescode == 200):
    print (response.text)
else:
    print("Error : " + response.text)