from datetime import datetime

header = '''
"Content-Type: application/vnd.apple.mpegurl"
"Access-Control-Allow-Origin: *"
"Access-Control-Expose-Headers: Content-Length,Content-Range"
"Access-Control-Allow-Headers: Range"
"Accept-Ranges: bytes"
'''
cache= datetime.now().strftime("%d%H%S")+ ".txt"  #d - The day of the month (from 01 to 31) H - 24-hour format of an hour (00 to 23) i - Minutes with leading zeros (00 to 59)
#print(cache)










import base64
import hashlib
import json
import time

with open('/workspace/ippyTV/+918830894345-creds.json', 'r') as f:
    creds = json.load(f)

ssoToken = creds['ssoToken']

def magic(str1):
    str2 = base64.b64encode(hashlib.md5(str1.encode('utf-8')).digest())
    print(f'str1= {str1}')
    print(f'str2= {str2}')
    return str2.replace(b'\n', b'').replace(b'\r', b'').replace(b'/', b'_').replace(b'+', b'-').replace(b'=', b'')

def generateToken():
    st = magic(ssoToken)
    print(f'st= {st}')
    pxe = int(time.time() + 6000000)
    print(f'pxe= {str(pxe)}')
    jct = magic("cutibeau2ic" + str(st) + str(pxe)).decode('utf-8').strip()
    print(f'jct= {jct}')
    return "?jct=" + jct + "&pxe=" + str(pxe) + "&st=" + st.decode('utf-8')

token = generateToken()
print(token)
#php = ?jct=CMcDWliU-bh2KUNzjAXNaA&pxe=1668664895&st=NJnvsx8bwXJSL-WaBtPWag
#py  = ?jct=7MV8VNQQj2tpFjRasGm_GQ&pxe=1668664341.7652967&st=NJnvsx8bwXJSL-WaBtPWag
#py  = ?jct=P5v8ZzIhRrRYFkg_1T4FMw&pxe=1668665056&st=NJnvsx8bwXJSL-WaBtPWag