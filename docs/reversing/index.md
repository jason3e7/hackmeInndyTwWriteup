### 第一次解 
# Reversing
### 就上手

jason3e7 20190605

Note:title:"第一次解 Reversing 就上手"

---

# Reversing
* [helloworld](#/2)
* [simple](#/3)
* [passthis](#/4)
* [pyyy](#/5)
* [accumulator](#/6)
* [GCCC](#/7)

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
* z3 語法不熟, 不要忘記 control flow, 我真的傻了 qq.
* `print Solver()`, 可以看一下裡面堆了什麼東西, debug 好用!?
* GRAY CODE 是什麼?

---

# The End