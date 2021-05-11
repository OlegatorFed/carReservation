<?php
    require ('includes/db.php');

    $data = $_POST;

    if (isset($data['do_login']))
    {
        if ($data['login'] == '' || $data['password'] == '')
        {
            $_SESSION['error'] = 'Enter login and password';
            header('Location: /');
        }
        elseif ($data['login'] == 'admin' && $data['password'] == 'admin')
        {
            $_SESSION['logged_user'] = $data['login'];
            header('Location: /admin_panel.php');
        }
        else
        {
            $_SESSION['error'] = 'Wrong login or password';
            header('Location: /');
        }
    }
?>
