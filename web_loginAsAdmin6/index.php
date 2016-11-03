<?php
@error_reporting(E_ALL^E_NOTICE);
require('config.php');

if($_GET['show_source'] === '1') {
    highlight_file(__FILE__);
    exit;
}

$user = null;

// connect to database

if(!empty($_POST['data'])) {
    try {
        $data = json_decode($_POST['data'], true);
    } catch (Exception $e) {
        $data = [];
    }
    extract($data);
    if($users[$username] && strcmp($users[$username], $password) == 0) {
        $user = $username;
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login As Admin 6</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="all">
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Login as Admin 6</h1>
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
<?php if(!$user && isset($_POST['data'])): ?>
            <div class="alert alert-danger">Login failed</div>
<?php endif; ?>
<?php if(!$user): ?>
            <form action="." method="POST" id="form_login">
                <div class="form-group">
                    <label for="username">User:</label>
                    <input id="username" class="form-control" type="text" name="name" placeholder="User">
                </div>
                <div class="form-group">
                    <label for="password">Pass:</label>
                    <input id="password" class="form-control" type="text" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-primary" type="submit" value="Login">
                </div>

                <input type="hidden" name="data" id="login_data" value="{}">
            </form>

            <div>
                <p>
                    You can login with <code>guest</code> / <code>guest</code>.
                </p>
            </div>

            <script>
            form_login.onsubmit = function () {
                login_data.value = JSON.stringify({
                    username: username.value,
                    password: password.value
                });
                username.value = null;
                password.value = null;
            };
            </script>
<?php else: ?>
            <h3>Hi, <?=htmlentities($username)?></h3>

            <h4><?=sprintf("You %s admin!", $user == 'admin' ? "are" : "are not")?></h4>

            <?php if($user == 'admin') printf("<code>%s</code>", htmlentities($flag)); ?>
<?php endif; ?>
        </div>
    </div>
</body>
</html>
