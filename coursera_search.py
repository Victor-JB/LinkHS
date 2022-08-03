import requests
import xmltodict, json

# credentials
account_sid = "IR7FdTDStn9y3560855gpgkhPoZX8TtgX1"
auth_token = "kPsxR-WH9hiSbhmeF-CcXmNxQPK6iuEk"

# api endpoint
url = f"https://api.impact.com/Mediapartners/{account_sid}/Ads"

response = requests.get(
    url, 
    auth=(account_sid, auth_token)
)

results = xmltodict.parse(response.content)