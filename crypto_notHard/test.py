#use python3
import base64

name = ["b16", "b32", "b64", "standard_b64", "urlsafe_b64", "b85", "a85"]

plaintext = "test"
encodetext = []

for n in name :
  e = "base64." + n + "encode(b\"" + plaintext + "\")"
  print(e)
  print(eval(e))
  encodetext.append(eval(e))

for s in encodetext :
  s = s.decode("utf-8")
  print("----------")
  for n in name :
    e = "base64." + n + "decode(b\"" + s + "\")"
    try :
      print(eval(e))
      print("decode by " + n)
    except:
      print("not " + n)
