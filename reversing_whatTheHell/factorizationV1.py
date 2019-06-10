import math 
  
def isPerfectSquare(x): 
  s = int(math.sqrt(x)) 
  return s*s == x 
  
def isFibonacci(n): 
  return isPerfectSquare(5*n*n + 4) or isPerfectSquare(5*n*n - 4) 

def check_prime(x):
  if ( x <= 1 ) :
    return 0
  if ( x <= 3 ) :
    return 1
  if ( (x & 1) == 0 ) :
    return 0
  if ( (x % 3) == 0 ) :
    return 0;
  i = 6
  while 1:
    if ( i * i > x ) :
      break    
    if ( (x % (i - 1)) == 0 ) :
      return 0
    if ( (x % (i + 1)) == 0 ) :
      return 0
    i += 6
  return 1

"""
def what(x) :
  if (x <= 1) :
    return x
  return what(x - 1) + what(x - 2)
"""
num = [2, 3, 857, 723563]
choose = [0, 0, 0, 0]

while 1 :
  x = 1
  y = 1
  for i in range(0, 4):
    if(choose[i] == 1) :
      x *= num[i]
    else :
      y *= num[i]
  print x," : ",y
  """
  if (x * y != 3720560946) :
    print str(x) +  " not good 1"
    continue
  """
  if ( (x ^ 126) * (y + 16) != 1931514558 ) :
    print str(x) +  " not good 2"
    #continue
  if ((((x & 0xffff) - (y & 0xffff)) & 0xFFF) != 0xCDF ) :
    print str(x) +  " not good 3"
    #continue
  if (check_prime(x) == 0) :
    print str(x) +  " not prime"
    #continue
  if (isFibonacci(x) == 0) :
    print str(x) +  " not fibonacci"
    #continue
  
  #print choose
  choose[0] += 1
  for i in range(0, 3):
    if(choose[i] >= 2) :
      choose[i] = 0
      choose[i + 1] += 1
  if (2 in choose) :
    break
