<?php
require('config.php');

// table schema
// user -> id, user, password, is_admin

if($_GET['show_source'] === '1') {
    highlight_file(__FILE__);
    exit;
}

function safe_filter($str)
{
    $strl = strtolower($str);
    if (strstr($strl, 'or 1=1') || strstr($strl, 'drop') ||
        strstr($strl, 'update') || strstr($strl, 'delete')
    ) {
        return '';
    }
    return str_replace("'", "\\'", $str);
}

$_POST = array_map(safe_filter, $_POST);

$user = null;

// connect to database

if(!empty($_POST['name']) && !empty($_POST['password'])) {
    $connection_string = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
    $db = new PDO($connection_string, DB_USER, DB_PASS);
    $sql = sprintf("SELECT * FROM `user` WHERE `user` = '%s' AND `password` = '%s'",
        $_POST['name'],
        $_POST['password']
    );
    try {
        $query = $db->query($sql);
        if($query) {
            $user = $query->fetchObject();
        } else {
            $user = false;
        }
    } catch(Exception $e) {
        $user = false;
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login As Admin 0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="all">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Login as Admin 0</h1>
        </div>
    </div>

    <div class="container">
        <div class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Please Hack Me</a>
                </div>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/scoreboard">Scoreboard</a>
                    </li>
                    <li>
                        <a href="?show_source=1" target="_blank">Source Code</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-6 col-md-offset-3">
<?php if(!$user): ?>
<?php if($user === false): ?>
            <!-- debug: <?=$sql?> -->
            <div class="alert alert-danger">Login failed</div>
<?php endif; ?>
            <form action="." method="POST">
                <div class="form-group">
                    <label for="name">User:</label>
                    <input id="name" class="form-control" type="text" name="name" placeholder="User">
                </div>
                <div class="form-group">
                    <label for="password">Pass:</label>
                    <input id="password" class="form-control" type="text" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-primary" type="submit" value="Login">
                </div>
            </form>

            <div>
                <p>
                    You can login with <code>guest</code> / <code>guest</code>.
                </p>
            </div>
<?php else: ?>
            <h3>Hi, <?=htmlentities($user->user)?></h3>

            <h4><?=sprintf("You %s admin!", $user->is_admin ? "are" : "are not")?></h4>

            <?php if($user->is_admin) printf("<code>%s</code>, %s", htmlentities($flag1), $where_is_flag2); ?>
<?php endif; ?>
        </div>
    </div>
</body>
</html>
