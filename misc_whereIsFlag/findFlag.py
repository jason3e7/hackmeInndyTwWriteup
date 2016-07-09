
import re

filename = 'flag'
with open(filename, 'r') as f:
	content = f.read()

m = re.search('FLAG{\w+}', content)
print m.group(0)
