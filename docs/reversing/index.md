### 第一次解 
# Reversing
### 就上手

jason3e7 20190603

Note:title:"第一次解 Reversing 就上手"

---

# Reversing
* [helloworld](#/2)
* [simple](#/3)
* [passthis](#/4)
* [pyyy](#/5)

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

# The End