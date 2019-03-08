# -*- coding: utf-8 -*-
import binascii

file = open("", "r") 
num = 1
bin = ''
for line in file :
  line = line.decode('utf-8')
  if(num % 16 == 2) :
    if(ord(line[4]) == 32) :
      bin = bin + '0'
    else : 
      bin = bin + '1'
  num += 1
n = int(bin, 2)
print binascii.unhexlify('%x' % n)

'''
file = open("pusheen.txt", "r") 
num = 1
for line in file :
  print num, line,
  line = line.decode('utf-8')
  if(num % 16 == 2) :
    print '-----',
    print line[4],
    print ord(line[4]),
    print '-----'
  if(num > 30) :
    break
  num += 1
'''
