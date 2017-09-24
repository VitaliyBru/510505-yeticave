<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

date_default_timezone_set('Europe/Moscow');
$is_auth = false;

$user = [];
/** @var array $user_login */
$login = ['email' => null, 'name' => null, 'fix_error' => false, 'wrong_data' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('login', $_POST)) {
    $login = $_POST['login'];
    if ($login['email'] && $login['password']) {
        $users = select_data($link, 'SELECT id, name, password, avatar FROM users WHERE email=?', [$login['email']]);
        $user = $users[0];
        if ($user && password_verify($login['password'], $user['password'])) {
            $user['password'] = null;
            session_start();
            $_SESSION['user'] = $user;
            header('location: /index.php');
            exit();
        } else{
            $login['wrong_data'] = true;
        }
    } else {
        $login['fix_error'] = true;
    }
}

$sql_categories = 'SELECT * FROM categories';
$categories = select_data($link, $sql_categories);

$page_content = renderTemplate('login', ['login' => $login]);
echo renderTemplate(
    'layout',
    [
        'page_content' => $page_content,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'title' => 'Вход'
    ]
);

