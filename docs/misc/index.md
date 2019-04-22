### 第一次解 
# Misc
### 就上手

jason3e7 20190422

Note:title:"第一次解 Misc 就上手"

---

## Misc part1
* [flag](#/4)
* [corgi can fly](#/5)
* [television](#/6)
* [meow](#/7)
* [where is flag](#/8)
* [encoder](#/9)

---

## Misc part2
* [pusheen.txt](#/11)
* [big](#/12)
* [otaku](#/13)
* [buzzing](#/14)
* [drvtry vpfr](#/15)

---

### Programming
* [fast](#/16)
### Lucky
* [you-guess](#/17)
### Forensic
* [easy pdf](#/18)
* [this is a pen](#/19)

---

## flag hint
* 目標 : What do you see !?

---

## corgi can fly hint
* 目標 : steganography, image
* file hex editor Or strings
* base64 
* LSB(Least Significant Bit)
* stegsolve
* qrcode 

Note:
* 原本是自己寫程式解的
  * question !?
    * Where is LSB ? RGB or RGBA ? 
    * Output is file or picture !?
  * RGB and picture !

---

## television hint
* 目標 : steganography, image
* view file as binary
* view file as hex
* strings

Note:
* 原本是自己寫程式解的

---

## meow hint
* 目標 : image, zip
* file format
* [10173502_279586372215628_1950740854_n.png](https://fbcdn-dragon-a.akamaihd.net/hphotos-ak-xat1/t39.1997-6/p296x100/10173502_279586372215628_1950740854_n.png), 已經失效
* binwalk
* pkcrack

Note:
* remove png save zip
  * use HxD 
  * find png file format end 
  * delete all png and save
* foremost -t all -i file -o outputDir
* pkcrack
  * install
    * wget https://www.unix-ag.uni-kl.de/~conrad/krypto/pkcrack/pkcrack-1.2.2.tar.gz
    * tar xzf pkcrack-1.2.2.tar.gz
    * cd pkcrack-1.2.2/src
    * make
    * (option)
    * mkdir -p ../../bin
    * cp extract findkey makekey pkcrack zipdecrypt ../../bin
    * cd ../../
  * usage
    * pkcrack -C [crypted_file] -c [mapping file path] -P [plaintext_file] -p [mapping file path] -d [output] -a
    * suggest -c and -p is same path
    * zip -r plain.zip meow

---

## where is flag hint
* 目標 : find flag
* regular expression

Note:
* `FLAG\{\w+\}`

---

## encoder hint
* 目標 : decode
* know encoder.py
* write decoder.py

---

## slow hint
* 目標 : brute force
* Side Channel Attack
  * timing attack

Note:
* [Python 多執行緒 threading 模組平行化程式設計教學](https://blog.gtwang.org/programming/python-threading-multithreaded-programming-tutorial/)

---

## pusheen.txt hint
* 目標 : decode
* color to binary
* binary to ascii

---

## big hint
* 目標 : decompress
* Need more than 20G space
* hex viewer
  * [xz-file-format-1.0.4](https://tukaani.org/xz/xz-file-format-1.0.4.txt)
    * Header Magic Bytes, FD 37 7A 58 5A 00
* command
  * file
  * strings
  * unxz
  * head
  * tail

---

## otaku hint
* 目標 : steganography, image
* strings
* binwalk
* stegsolve

Note:
* [wikipedia](https://zh.wikipedia.org/wiki/File:Miku_Hatsune.png)
* [Miku_Hatsune.png](https://web.archive.org/web/20151106000405/https://upload.wikimedia.org/wikipedia/zh/0/00/Miku_Hatsune.png)
* [compare(imagemagick)](https://imagemagick.org/script/compare.php), kali default
  * compare -compose src file1.png file2.png diff.png
* [A Challengers Handbook](http://www.caesum.com/handbook/stego.htm)

---

## buzzing hint
* 目標 : steganography, image
* file format(magic number)
* format header
* size

Note:
DIB : width in pixels * height in pixels * bits per pixel = image size

---

## drvtry vpfr hint
* 目標 : find encode
* google

Note:
* why google detect "secret code".
* drvtry vpfr -> secret code.

---

## fast hint
* 目標 : Professionally ProgramCoder

---

## you-guess hint
* 目標 : guess password
* Brute force
* observed !?

Note:
* [female-names.gz](https://packetstormsecurity.com/files/32072/female-names.gz.html)

---

## easy pdf hint
* 目標 : find flag
* chrome `find` flag
* pdf analyze
* pdf-parser

Note:
* origami
* [pdfparser](https://www.pdfparser.org/demo)

---

## this is a pen hint
* 目標 : find flag
* pdf analyze
* pdf-parser

Note:
* origami
* [extractpdf](https://www.extractpdf.com/)

---

# The End