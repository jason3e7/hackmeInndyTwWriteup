### 第一次解 
# [Hackme CTF](https://hackme.inndy.tw/)
### 就上手

jason3e7 20181126

---

# Web
* [dafuq-manager 1](#/2)
* [dafuq-manager 2](#/3)

---

## dafuq-manager 1 hint
* ```Do you know cookie? Create a cookie named `help` with value `me`!```
* [Back to Web](#/1)

---

## dafuq-manager 2 hint
* 目標 : 登入 admin
* 如果可以快速架環境, 就架環境.(黑箱變成白箱)
  * conf, https -> http
* 分析權限管控機制, 登入流程
* 切入點
  * bypass權限管控, 直接顯示 admin 頁面
  * 登入驗證
    * Injection
  * 抓取密碼檔 
    * Path Traversal

Note:index.php?action=x

---

### dafuq-manager 2 - 分析權限管控機制
* index.php(action = admin)
  * /core/fun_admin.php
    * show_admin()
      * $GLOBALS["permissions"] from activate_user().

---

### dafuq-manager 2 - 分析登入流程
* /core/login.php
  * activate_user()
    * md5(stripslashes($p_pass)))
  * /core/fun_users.php
    * /.config/.htusers.php, 帳號資料檔(包含密碼)
    * &find_user()

---

### dafuq-manager 2 - bypass權限管控, 直接顯示 admin 頁面
* /core/login.php
  * activate_user()
  * /core/fun_users.php
    * /.config/.htusers.php, $GLOBALS["permissions"]都從這包帶出.
* 目前沒有辦法走這條路 Compromise. 

---

## dafuq-manager 2 - 登入驗證
* &find_user function
  * $pass == NULL
    * 如果是等於 0, 就有[Magic Hashes](https://www.whitehatsec.com/blog/magic-hashes/)可以用.
  * 不是 SQL, 沒有 SQL injection
* 目前沒有辦法走這條路 Compromise. 

---

## dafuq-manager 2 - 抓取密碼檔
* search and list
  * 只顯示檔案不是存取
* download
  * basename(), protect
* arch
  * I got you !
* debug
  * dafuq-manager 3 的入口

---

## dafuq-manager 2 - arch
* /core/fun_archive.php
  * zip_items
    * ```$GLOBALS['__POST']["selitems"][$i]```
    * sanitize()
* /core/secure.php
  * sanitize(), 不安全
* [Back to Web](#/1)

---

# The End
