
import binascii
import re

filename = 'television.bmp'
with open(filename, 'rb') as f:
	content = f.read()
m = re.search('FLAG{(.*)}', binascii.hexlify(content).decode("hex"))
print m.group(0)
