### 第一次解 
# [Hackme CTF](https://hackme.inndy.tw/)
### 就上手

jason3e7 20181127

---

# Web
* [dafuq-manager 1](#/2)
* [dafuq-manager 2](#/3)
* [dafuq-manager 3](#/10)

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

## dafuq-manager 3 hint
* 目標 : 使用 web shell, 取得網站目錄底下的 flag 
* 切入點
  * debug

Note:index.php?action=x

---

## dafuq-manager 3 debug
* /core/init.php
  * $GLOBALS["dir"]
* /core/fun_debug.php
  * strcmp($dir, "magically")...
  * [Unauthorized Access: Bypassing PHP strcmp()](http://danuxx.blogspot.com/2013/03/unauthorized-access-bypassing-php-strcmp.html)

---

## dafuq-manager 3 learn
* php 執行系統外部命令
  * proc_open
    * ```$process = proc_open('ls', array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w")), $pipes); print(stream_get_contents($pipes[1]));```
  * pcntl_exec, 需要補充
  * ob_start(), 需要補充

---

## dafuq-manager 3 learn
* php 執行php外部命令
  * eval("phpinfo();");
  * assert(), 需要補充
  * print(preg_replace_callback('/cmd/e', phpinfo(), 'cmd'));
  * $func = create_function('$arg1', 'phpinfo();'); $func(1);
  * array_map('phpinfo', array(0, 1));
    * 限制只有 function name
  * ```$_GET["function"]($_GET["cmd"]);```

---

## dafuq-manager 3 learn
* php, code inclusion
  * include
  * include_once
  * require
  * require_once
  * curl, 需要補充, 不一定在這個分類.

Note:[Exploitable PHP functions](https://stackoverflow.com/questions/3115559/exploitable-php-functions)
順便有的 keyword : 
* [利用環境變數LD_PRELOAD來繞過php disable_function執行系統命令 <轉載>](https://codertw.com/%E4%BC%BA%E6%9C%8D%E5%99%A8/138881/)
* [Exploit with PHP Protocols / Wrappers](https://www.cdxy.me/?p=752)
* [Finding vulnerabilities in PHP scripts (FULL)](https://www.exploit-db.com/papers/12871)
* [Web-shells 101 using PHP – Introduction to Web Shells – Part 2](https://www.acunetix.com/blog/articles/web-shells-101-using-php-introduction-web-shells-part-2/)

---


Note:
eval(base64_decode('c3lzdGVtKCdscycpOw=='));

---

# The End
