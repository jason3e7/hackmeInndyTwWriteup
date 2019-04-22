<?php
require('config.php');
require('session.php');

// class Session { ... }

// sorry, no source code this time. :P

$session = Session::load();
$login_failed = false;

if($_GET['show_source'] === '1') {
    highlight_file(__FILE__);
    exit;
}

if($_GET['debug'] === '1') {
    $session->debug();
}

if(isset($_POST['name'])) {
    $login_failed = !Session::login($_POST['name'], $_POST['password']);
} else if(isset($_POST['logout'])) {
    $session = new Session();
}

$session->save();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login As Admin 8</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="all">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Login as Admin 8</h1>
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
<?php if($login_failed): ?>
<?php     if($_POST['name'] === 'admin'): ?>
            <div class="alert alert-danger">Nice try. Login failed</div>
<?php     else: ?>
            <div class="alert alert-danger">Login failed</div>
<?php     endif; ?>
<?php elseif($session->is_admin): ?>
            <div class="alert alert-success">Hello, admin! Here is your flag: <code><?=$flag?></code></div>
<?php elseif($session->user): ?>
            <div class="alert alert-info">Hello, <?=$session->user?>. You are not admin, no flag for you! :P</div>
<?php endif; ?>

<?php if($session->user): ?>
            <form action="." method="POST">
                <input type="hidden" name="logout" value="true">
                <div class="form-group">
                    <input class="form-control btn btn-danger" type="submit" value="Logout">
                </div>
            </form>
<?php else: ?>
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
<?php endif; ?>
        </div>
    </div>
</body>
</html>