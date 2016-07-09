from PIL import Image
im = Image.open("corgi-can-fly.png")

print im.mode
(w, h) = im.size

for x in range(w):
	for y in range(h):
		rgb = im.getpixel((x,y))
		result = 255
		for i in (0, 2) :
			if (rgb[i] & 1) == 0 : 
				result = 0
		rgb = (result, result, result)
		im.putpixel((x,y), rgb)
		
im.save("flag.png")

'''
#ref:http://blog.l4ys.tw/2015/12/tmctf-final-2015-binary2/
img = im.convert('RGBA')
pix = im.load()
(w, h) = im.size
out = []

for x in range(w):
	for y in range(h):
		r,g,b,a = pix[x,y]
		out.append(str(a & 1))
		out.append(str(r & 1))
		out.append(str(g & 1))
		out.append(str(b & 1))

o = ""
for i in range(0, len(out), 8):
	o += chr(int("".join(out[i:i+8]), 2))
open("file", "wb").write(o)
'''

