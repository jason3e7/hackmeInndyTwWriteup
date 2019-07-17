### 第一次解 
# Pwn
### 就上手

jason3e7 20190717

Note:title:"第一次解 Pwn 就上手"

---

# Pwn
* [catflag](#/2)

Note:
* 要怎麼錄過程呢!?
  * `tcpdump host 140.118.126.236 -w output.pcap`
* 怎麼自己架設一樣的環境呢
  * `socat tcp-l:9999,fork exec:./execfile`

---

## catflag hint
* 目標 : get flag
* 方向 : 
  * `nc hackme.inndy.tw 7709`
  * linux command
* [Back to Pwn](#/1)

Note:
* 感覺是寫固定 pattern 的程式.

---

# The End
