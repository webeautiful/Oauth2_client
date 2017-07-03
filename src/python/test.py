# -*- coding:utf-8 -*-
import requests

if __name__ == '__main__':
    payload = {
            'grant_type':'client_credentials',
            'client_id':'Your_App_Key',
            'client_secret':'Your_App_Secret'
            }
    r = requests.post("http://api.pigai.org/oauth2/access_token", data=payload)
    print r.text
