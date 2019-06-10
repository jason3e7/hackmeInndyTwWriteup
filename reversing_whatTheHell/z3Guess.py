from z3 import *

s = Solver()

x = BitVec('x', 32)
y = BitVec('y', 32)

s.add(x * y == 3720560946)
s.add((x ^ 126) * (y + 16) == 1931514558)
s.add((((x & 0xffff) - (y & 0xffff)) & 0xfff) == 0xcdf)

print s

while s.check() == sat:
  ans = s.model()
  print(ans)
  s.add(x != ans[x])
