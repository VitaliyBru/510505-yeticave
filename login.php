<?php
require_once 'userdata.php';
require_once 'functions.php';

date_default_timezone_set('Europe/Moscow');
$is_auth = false;

/** @var array $user_login */
$user_login = ['email' => null, 'name' => null, 'form_valid' => true];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (array_key_exists('email', $_POST) || array_key_exists('password', $_POST)) {
        $user_login = userAuthenticator($users, $user_login);
    } else {
        $user_login['form_valid'] = false;
    }
}

if ($user_login['name']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
    setcookie('username', $user_login['name'], strtotime('+1 day'));
    exit();
} else {
    $page_content = renderTemplate('login', ['user_login' => $user_login]);
    echo renderTemplate(
        'layout',
        [
            'page_content' => $page_content,
            'is_auth' => $is_auth,
            'title' => 'Вход'
        ]
    );
}
