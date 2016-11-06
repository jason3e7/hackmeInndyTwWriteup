# key #
1. trace code 
	1. <?php elseif($user === 'admin'): ?>
	2. if($_POST['name'] == 'admin' && md5($_POST['password']) == '00000000000000000000000000000000') { 
2. == 不判斷型別
	1. if ((true == "foo") && ("foo" == 0) && (0 == false)) echo "yay!";
	2. magic hashes 
		1. https://www.whitehatsec.com/blog/magic-hashes/
		2. 找時間寫下detail
	3. md5('240610708') == md5('QNKCDZO')
		1. https://news.ycombinator.com/item?id=9484757
3. RkxBR3tTY2llbnRpZmljIG5vdGF0aW9uIGlzIGF3ZXNvbWUhISF9
