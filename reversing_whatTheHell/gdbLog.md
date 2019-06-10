# gdb log #
## solution 1 ##
* `4284256177-1234567890`
* `jump *0x08048830`
* `set *((int *) 0xffffcf18) = 4140025247`, 改 傳入的參數值

## solution 2 ##
* `4284256177-1234567890`
* `set *((int *) 0xffffcefc) = 887`, 改 i 值
* `jump *0x08048830`

## show value ##
* `mov    DWORD PTR [ebp-0xc],0x1`
```
p $ebp-0xc
> 0xffffcefc
p ＊0xffffcefc
> 1
```
