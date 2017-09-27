<?php
require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

$sign = [['email' => null, 'name' => null, 'password' => null, 'avatar' => null, 'contacts' => null], 'errors' => null];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('sign', $_POST)) {
    $sign = getDataSignInForm($_POST);
    if (isset($_FILES) && array_key_exists('userImage', $_FILES) && $_FILES['userImage']['name']) {
        $sign[0]['avatar'] = getImageFilePostForm($_FILES);
    }
    if (!$sign['errors']) {
        if (!select_data($link, 'SELECT id FROM users WHERE email=?', [$sign[0]['email']])) {
            $sign[0]['password'] = password_hash($sign[0]['password'], PASSWORD_DEFAULT);
            if (insert_data($link, 'users', $sign[0])) {
                header('location: /login.php?new=1');
                exit();
            } else {
                echo 'Не удалось добавить нового пользователя';
                exit();
            }
        } else {
            echo 'Этот адрес почты уже занят';
            exit();
        }
    }
}

$categories = getCategoriesList($link);
$page_content = renderTemplate(
    'sign-in',
    [
        'sign' => $sign,
        'categories' => $categories
    ]
);
echo renderTemplate(
    'layout',
    [
        'categories' => $categories,
        'page_content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'user_avatar' => $user_avatar,
        'title' => 'Регистрация'
    ]
);