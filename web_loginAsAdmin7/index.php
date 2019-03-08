<?php
require('config.php');

if($_GET['show_source'] === '1') {
    highlight_file(__FILE__);
    exit;
}

if($_POST['name'] == 'admin' && md5($_POST['password']) == '00000000000000000000000000000000') {
    // admin account is disabled by give a impossible md5 hash
    $user = 'admin';
} elseif($_POST['name'] == 'guest' && md5($_POST['password']) == '084e0343a0486ff05530df6c705c8bb4') {
    $user = 'guest';
} elseif(isset($_POST['name'])) {
    $user = false;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login As Admin 7</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="all">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Login as Admin 7</h1>
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
<?php if($user === false): ?>
            <div class="alert alert-danger">Login failed</div>
<?php elseif($user === 'admin'): ?>
            <div class="alert alert-success">Hello, admin! Here is your flag: <code><?=$flag?></code></div>
<?php elseif($user): ?>
            <div class="alert alert-info">You are not admin, no flag for you! :P</div>
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
