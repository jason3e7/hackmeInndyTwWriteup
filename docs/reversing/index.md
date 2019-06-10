### 第一次解 
# Reversing
### 就上手

jason3e7 20190610

Note:title:"第一次解 Reversing 就上手"

---

# Reversing
* [helloworld](#/2)
* [simple](#/3)
* [passthis](#/4)
* [pyyy](#/5)
* [accumulator](#/6)
* [GCCC](#/7)
* [ccc](#/8)
* [bitx](#/9)
* [what-the-hell](#/10)

Note:
* IDA pro, F5 大絕招
* 技術債
  * gdb

---

## helloworld hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招

Note:ELF 32-bit LSB executable

---

## simple hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招

Note:ELF 32-bit LSB executable

---

## passthis hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招

Note:
* PE32 executable for MS Windows (console) Intel 80386 32-bit
* 很大一部分用猜的, 並不是真的都看懂了
* IDA pro 的反組譯最好當做參考, 有問題還是看組語最準
* v6 == '\r', return "Good"
  * [_bittest](https://docs.microsoft.com/zh-tw/cpp/intrinsics/bittest-bittest64?view=vs-2019), 是什麼?, 有sample code, 該指令會檢查位址 b 的位置 a 中的位元，並傳回該位元的值。
    * `v5 = 9217, _bittest(&v5, v6)`, 10010000000001
      * v6, 0, 10, 13 => (null), (NL line feed, new line), (carriage return)  
  * `v6 <= '\r'`, 為什麼?
* 技術債
  * `iob[0]._ptr`, 是什麼?
  * 好像還有一些圖片和網路下載的操作.
  * 這隻很多語法看不懂

---

## pyyy hint
* 目標 : 取得 flag
* pyc decompile

Note:
* pyc, Python bytecode
* 用 010 Editor 打開可以看到像是組語的東西.
* [code object](https://ctf-wiki.github.io/ctf-wiki/misc/other/pyc/), 有進階的難題可練習
  * [Python程序的執行原理](http://python.jobbole.com/84599/), pyc format
  * [opcode.h](https://github.com/python/cpython/blob/fc7df0e664198cb05cafd972f190a18ca422989c/Include/opcode.h)
* [Python Decompiler](https://python-decompiler.com/)
* [[Linux] 使用 Decompile++ (pycdc) 反組譯 pyc 檔案](https://ephrain.net/linux-%E4%BD%BF%E7%94%A8-decompile-pycdc-%E5%8F%8D%E7%B5%84%E8%AD%AF-pyc-%E6%AA%94%E6%A1%88/)

---

## accumulator hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招

Note:
* ELF 64-bit LSB executable
* 很大一部分用猜的, 並不是真的都看懂了
* IDA pro 的反組譯最好當做參考, 有問題還是看組語最準
* `SHA512(&data, inputSize, &hash)` 之後 `sub_4008C0(&hash, 64LL);`, 長度 64, SHA512 output, 一組hex, 兩個值, 64 * 2, 128.
* 技術債
  * `*(&v7 + ++inputSize) = v4;` 和 `SHA512(&data, inputSize, &hash)` 的 data 是怎麼接上的.
  * sub_4008C0 function 裡面, `unsigned __int8 *index; // rax`, 初始化的值是什麼, 是不是全域變數, 沒看到宣告.
  * `dword_6013C0`, 值是什麼?
  * 這隻更多語法看不懂
* [Online Tools](https://emn178.github.io/online-tools/index.html)

---

## GCCC hint
* 目標 : 取得 flag
* .NET Decompiler 大絕招, z3

Note:
* PE32 executable for MS Windows (console) Intel 80386 32-bit Mono/.Net assembly
* 建立 .NET framework 的環境, 從 microsoft 抓.
* 安裝 .NET Decompiler 的環境, 不只有一套.
* 安裝 z3 的環境, 編譯有點久.
* z3 要特別注意改寫之後的各個的 type.
* z3 語法不熟, 不要忘記 control flow, 我真的傻了 qq.
* `print Solver()`, 可以看一下裡面堆了什麼東西, debug 好用!?
* GRAY CODE 是什麼?

---

## ccc hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招

Note:
* 一開始就有發現 crc32("FLA") == 0xD641596F
* 想說用 z3 解, 應該也是真的可以用 z3 解, 但是 crc32 要自己重寫
  * [z3 crc example](https://gist.github.com/percontation/11310679)
  * [crc32.py](https://github.com/sam-b/z3-stuff/blob/master/crc32/crc32.py)
* crc32 可以直接暴力破解
* 想的太難了 qq

---

## bitx hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招

Note:
* 太心急了, 沒有辨別出陣列取值, 這題真的蠻簡單.
* 不要一直想要用 z3 解, 是沒有簡單解法, 而且符合數學可收斂狀態, 再使用.

---

## what-the-hell hint
* 目標 : 取得 flag
* IDA pro, F5 大絕招, z3

Note:
* ELF 32-bit LSB executable
* 有數學式可以用 z3 先跑出可能性
* [A Primality Test](https://primes.utm.edu/curios/includes/primetest.php)
* 用 c 模擬 what function, 只有 int 的大小, Fibonacci 很快就會 overflow, 所以不能用正常方式檢查.
  * [fibonacci number tester ](https://onlinemathtools.com/test-fibonacci-number)
* [what-the-hell](https://www.cnblogs.com/WangAoBo/p/hackme_inndy_writeup.html#_label24), 是寫程式去模擬 decrypt_flag.
* 這題的原始要考什麼呢?, `Tips: modinv, Something is slow there in my code, make it faster.`
* [質因數在線計算器](http://www.ab126.com/shuxue/2822.html), 輸入是 unsigned int, 所以也可能是 overflow, 分解的值會錯.
* c 的 main function 外面宣告的變數, 不能在外面直接改值嗎?
* gdb, 有點回來了, 但是很多操作還是不熟.
* IDA pro, patch file. 
* 最近做的感覺已經不是 Reversing, 因為 F5 就出來了, 問題變成是
  * 模擬執行
  * runtime 修改參數
  * patch file

---

# The End