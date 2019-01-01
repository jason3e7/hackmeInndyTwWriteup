### 第一次解 
# login as admin
### 就上手

jason3e7 20190101

Note:title:"第一次解 login as admin 就上手"

---

# Web
* [login as admin 0](#/2)

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

# The End
