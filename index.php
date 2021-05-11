<?php
    require ('includes/db.php');

    if ($_SESSION['logged_user'] === 'admin')
    {
        header('Location: /admin_panel.php');
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin log in</title>
</head>
<body style="display: flex; justify-content: center; align-items: center;  flex-direction: column">
<?if (isset($_SESSION['error'])) { echo '
    <p>
        '. $_SESSION["error"] .'
</p>
';
unset($_SESSION['error']);
} ?>
<form action="login.php" method="post" style="align-items: center">
    <p>
        Login
        <input type="text" name="login">
    </p>
    <p>
        Password
        <input type="password" name="password">
    </p>
    <p>
        <button type="submit" name="do_login">Log in</button>
    </p>
</form>
</body>
</html>
