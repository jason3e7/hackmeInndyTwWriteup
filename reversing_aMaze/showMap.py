import binascii

f = open("map","rb")
mapBin = f.read()
f.close()

mapHex = binascii.hexlify(mapBin)

def hexToInt(s) : 
  s = [s[i:i+2] for i in range(0, len(s), 2)]
  s = s[::-1]
  s = "".join(s)
  return int(s, 16)

count = 0
for i in range(0, 128) :
  if (i % 4 == 0) :
    print "0x%s0" % hex(count)[2:].zfill(3),
    count += 1 
  begin = i * 8
  print mapHex[begin:begin + 8],
  #print hexToInt(mapHex[begin:begin + 8]),
  if (i % 4 == 3) :
  	print ""



  
