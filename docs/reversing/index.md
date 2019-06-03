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

# The End