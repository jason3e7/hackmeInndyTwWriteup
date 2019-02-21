### 第一次解 
# Crypto
### 就上手

jason3e7 20190221

Note:title:"第一次解 Crypto 就上手"

---

# Crypto
* [easy](#/2)
* [r u kidding](#/3)
* [not hard](#/4)

Note:
* 目標
  * 能自動化測試字串格式, 每種字串的特徵.
  * encode 型的題目都要能解
  * 古典密碼要幾乎能解
  * 現代密碼概念要知道
  * 要組織自動暴力破解工具

---

## easy hint
* 目標 : `526b78425233745561476c7a49476c7a4947566863336b7349484a705a3268305033303d`
* 方向 : 分析字串格式

Note:
* 0~9a~d
  * [hex-to-ascii](https://www.rapidtables.com/convert/number/hex-to-ascii.html)
* end is =

---

## r u kidding hint
* 目標 : `EKZF{Hs'r snnn dzrx, itrs bzdrzq bhogdq}`
* 方向 : 分析字串格式

Note:
* caesar-cipher, ROT13
  * [Caesar cipher](http://planetcalc.com/1434/)

---

## not hard hint
* 目標 : `Nm@rmLsBy{Nm5u-K{iZKPgPMzS2I*lPc%_SMOjQ#O;uV{MM*?PPFhk|Hd;hVPFhq{HaAH<`
* 方向 : 分析字串格式
* run `pydoc3 base64`

Note:
* `pydoc3 base64`
  * `base64 - Base16, Base32, Base64 (RFC 3548), Base85 and Ascii85 data encodings`

---

# The End
