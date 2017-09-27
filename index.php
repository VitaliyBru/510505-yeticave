<?php
require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

/** @var bool $is_auth is true if user is authorized */
$is_auth = false;
/** @var string $user_name */
$user_name = null;
/** @var string $user_avatar contains a path to user avatar image */
$user_avatar = null;
session_start();
if (isset($_SESSION['user'])) {
    $is_auth = true;
    $user_name = $_SESSION['user']['name'];
    $user_id = $_SESSION['user']['id'];
    $user_avatar = $_SESSION['user']['avatar'];
}

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$categories = getCategoriesList($link);
$id = (int) ($_GET['id'] ?? null);
$page_data = indexDataBuilder($link, $id, $_GET);
/** @var string $page_content Contains html code */
$page_content = renderTemplate('pagination', ['pages' => $page_data['pages'], 'id' => $id]);
$page_content = renderTemplate(
    'index',
    [
        'page_content' => $page_content,
        'categories' => $categories,
        'lots' => $page_data['lots'],
    ]
);
echo renderTemplate(
    'layout',
    [
        'page_content' => $page_content,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'user_avatar' => $user_avatar,
        'title' => 'Главная'
    ]
);
