### 第一次解 
# Pwn
### 就上手

jason3e7 20190721

Note:title:"第一次解 Pwn 就上手"

---

# Pwn
* [catflag](#/2)
* [homework](#/3)

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

## homework hint
* 目標 : get shell
* 方向 : 
  * index out bound
  * Return Address
* [Back to Pwn](#/1)

Note:
* use tools
  * gdb-peda
  * ida pro, 不一定需要
* 要知道 call function 時候 stack 的變化, 可以 google search `call function stack`.
* step
  * find call_me_maybe(memory), `0x80485fb, 134514171`
    * `disassemble call_me_maybe`
  * find run_program return address(memory), `arr[14]`
    * 連續塞值, 觀察 stack
    * `context stack 24`
  * use write function overwrite run_program return address
* [GDB cheatsheet](https://darkdust.net/files/GDB%20Cheat%20Sheet.pdf)
* [peda_cheatsheet](https://github.com/ebtaleb/peda_cheatsheet/blob/master/peda.md)

---

# The End
