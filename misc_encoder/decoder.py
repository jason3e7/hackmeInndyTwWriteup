#!/usr/bin/env python2

import random
import string

def rot13(s):
    return s.translate(string.maketrans(
	    string.uppercase[13:] + string.uppercase[:13] +
        string.lowercase[13:] + string.lowercase[:13], 
        string.uppercase + string.lowercase
        ))

def base64(s):
    return ''.join(s.decode('base64').split())

def hex(s):
    return s.decode('hex')

def upsidedown(s):
    return s.translate(string.maketrans(
	    string.uppercase + string.lowercase,
        string.lowercase + string.uppercase))

E = (rot13, base64, hex, upsidedown)

flag = open('flag.enc', 'r').read()

count = 1
while(1) :
    num = flag[0:1]
    sub = flag[1:]
    if num == 'F' : 
		print num + sub
		break
    flag = E[int(num)](sub)
    count = count + 1
    if count == 48 :
		print flag
		break
