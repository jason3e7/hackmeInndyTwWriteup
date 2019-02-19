# Programming	fast #
## solution 1 ##
* fast.py 
  * fast_test.py, 測試過程中知道, 很可能被限制在 int 裡面, 而且 python 負數除法比較特別.

## solution 2 ##
* fast_c.py, call c lib
  * cal_so.c, `gcc cal_so.c -shared -o cal.so`

## solution 3 ##
* python call subprocess, cal.c
  * 速度太慢了

## solution 4 ##
* c socket, client.c 未完成