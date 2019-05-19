### 第一次解 
# login as admin
### 就上手

jason3e7 20190519

Note:title:"第一次解 login as admin 就上手"

---

# Web
* [login as admin 0](#/2)
* [login as admin 0.1](#/5)
* [login as admin 1](#/8)
* [login as admin 1.2](#/11)
* [login as admin 3](#/14)
* [login as admin 8](#/15)
* [login as admin 8.1](#/16)

---

## login as admin 0 hint
* 目標 : 登入 admin 權限
* 分析權限管控機制, 登入流程
* 切入點
  * trace code, 反向去看
  * 有 `<!-- debug: -->` 可以看
  * table schema, 也給的很明確

---

## login as admin 0 trace code
```
<?php if($user->is_admin) printf("<code>%s</code>, %s", htmlentities($flag1), $where_is_flag2); ?>
$user = $query->fetchObject();
$query = $db->query($sql);
$sql = sprintf("SELECT * FROM `user` WHERE `user` = '%s' AND `password` = '%s'", $_POST['name'], $_POST['password']);
```

Note:需要一點巧思, 看 table schema

---

## login as admin 0 safe_filter
```
strstr, 'or 1=1' || 'drop' || 'update' || 'delete'
str_replace("'", "\\'", $str)
```
* [Back to Web](#/1)

Note:簡單的 filter

---

## login as admin 0.1 hint
* 目標 : SQLi, UNION
* 接續 login as admin 0, 程式碼一模一樣.
* 切入點
  * flag2 in the database!
  * UNION
  * SQL 學習之路

Note:除了UNION, 可以從 sqlmap 學習其他黑科技.

---

## login as admin 0.1 SQL
* UNION 指令的目的是將兩個 SQL 語句的結果合併起來。
* information_schema
  * List Databases
  * List Tables
  * List Columns
* Select Nth Row

Note:
* [SQL UNION](https://www.1keydata.com/tw/sql/sqlunion.html)
* [MySQL SQL Injection Cheat Sheet](http://pentestmonkey.net/cheat-sheet/sql-injection/mysql-sql-injection-cheat-sheet)
* [Sql injection 幼幼班](https://www.slideshare.net/hugolu/sql-injection-61608454)

---

## login as admin 0.1 select
```
select schema_name from information_schema.schemata limit 0,1
select table_name from information_schema.tables where table_schema="schema_name" limit 0,1
select column_name from information_schema.columns where table_schema="schema_name" and table_name="table_name" limit 0,1
select concat(column_name) from schema_name.table_name limit 0,1
```
* [Back to Web](#/1)

---

## login as admin 1 hint
* 目標 : 登入 admin 權限
* 分析權限管控機制
* 切入點
  * trace code, 反向去看
  * SQLi

Note:
* [SQL Logic Operator Precedence: And and Or](https://stackoverflow.com/questions/1241142/sql-logic-operator-precedence-and-and-or)

---

## login as admin 1 trace code
```
<?php if($user->isadmin) printf("<code>%s</code>, %s", htmlentities($flag1), $where_is_flag2); ?>
$user = $query->fetchObject();
$query = $db->query($sql);
$sql = sprintf("SELECT * FROM `%s` WHERE `name` = '%s' AND `password` = '%s'",
        USER_TABLE,
        $_POST['name'],
        $_POST['password']
    );
```

Note:
參考admin 0, 需要一點巧思, 看 table schema

---

## login as admin 1 safe_filter
```
strstr, " " || "1=1" || "''" || "union select" || "select "
str_replace("'", "\\'", $str)
```
* [Back to Web](#/1)

Note:
參考admin 0, 簡單的 filter, 需要一點巧思()
* [SQL injection with no spaces](https://stackoverflow.com/questions/49682143/sql-injection-with-no-spaces)

---

## login as admin 1.2 hint
* 目標 : boolean-based SQL injection
* 接續 login as admin 1, 程式碼一模一樣.
* 切入點
  * flag2 in the database!
  * information_schema
  * sqlmap 學習之路

Note:SQL injection 撈資料應該都能使用 sqlmap 去跑, 只是可能需要客製化 payload.

---

## login as admin 1.2 safe_filter
```
strstr, " " || "1=1" || "''" || "union select" || "select "
str_replace("'", "\\'", $str)
```

Note:
參考sqlmap tamper, 簡單的 filter, 不只有一種 bypass 方法 `/**/`.
* [tamper](https://github.com/sqlmapproject/sqlmap/tree/master/tamper)


---

## login as admin 1.2 sqlmap
* --force-ssl, https 加上這個比較不會有問題. 
* --technique=B, 已經提示 boolean-based, 可以不用測試其他的.
* --tamper=space2comment,escapequotes, 原本使用 burp 去 replace, sqlmap 原生就有, 也可以自己客製化.
* --risk=3 --level=5, 可以跑比較多的不同 payload.
* `sqlmap/xml/payloads/*`, 已經確認可以跑的 payload, 可以自己改寫.
* [Back to Web](#/1)

Note:
* 確認 sql injection 之後可以去改寫原始 payload, 撈資料會比較快.

---

## login as admin 3 hint
* 目標 : 登入 admin 權限
* 分析權限管控機制(cookie)
* 切入點
  * function load_user()
  * == vs. ===
  * [PHP Magic Tricks: Type Juggling](https://www.owasp.org/images/6/6b/PHPMagicTricks-TypeJuggling.pdf)
* [Back to Web](#/1)

---

## login as admin 8 hint
* 目標 : 登入 admin 權限
* 分析權限管控機制(cookie and session)
* 切入點
  * $session->is_admin
  * 沒有source code, 黑箱測試
  * cookie分析
* [Back to Web](#/1)

Note:
* [SHA512](https://emn178.github.io/online-tools/sha512.html)
* [PHP Object Injection](https://www.owasp.org/index.php/PHP_Object_Injection)  

---

## login as admin 8.1 hint
* 目標 : 找出隱藏的 flag
* 切入點
  * debug
* [Back to Web](#/1)

---

# The End
