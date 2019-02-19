from pwn import *
import numpy as np
import time

r = remote('hackme.inndy.tw', 7707)
for x in range(3):
  print r.recvline()
r.sendline("Yes I know")

question = []
output = []

for x in range(10000):
  q = r.recvline()
  arr = q.split()

  if(arr[1] == '+') :
    count = int(arr[0]) + int(arr[2])
  elif(arr[1] == '-') :
    count = int(arr[0]) - int(arr[2])
  elif(arr[1] == '*') :
    count = int(arr[0]) * int(arr[2])
  elif(arr[1] == '/') :
    count = int(arr[0]) / int(arr[2])
  else :
    count = -1

  question.append(arr)
  output.append(count)

for x in range(10000):
  print question[x]
  print output[x]
  # out of int, negative number divide
  r.sendline(str(output[x]))
  print r.recvline(timeout = 0.05)