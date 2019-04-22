### 第一次解 
# login as admin
### 就上手

jason3e7 20190422

Note:title:"第一次解 login as admin 就上手"

---

# Web
* [login as admin 0](#/2)
* [login as admin 0.1](#/5)
* [login as admin 3](#/8)
* [login as admin 8](#/9)

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

Note:
* [SHA512](https://emn178.github.io/online-tools/sha512.html)  

---

# The End
