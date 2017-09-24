<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'lots_list.php';

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

$sql_categories = 'SELECT * FROM categories';
$categories = select_data($link, $sql_categories);
$id = (int) ($_GET['id'] ?? null);
if ($id) {
    $sql_lot = 'SELECT l.id, l.name, l.image, l.price_start, l.date_end, c.name AS category FROM lots AS l 
    JOIN categories AS c ON l.category_id=c.id WHERE l.date_end > NOW() AND l.category_id=? ORDER BY l.id DESC';
    $lots = select_data($link, $sql_lot, [$id]);
} else {
    $sql_lot = 'SELECT l.id, l.name, l.image, l.price_start, l.date_end, c.name AS category FROM lots AS l 
    JOIN categories AS c ON l.category_id=c.id WHERE l.date_end > NOW() ORDER BY l.id DESC';
    $lots = select_data($link, $sql_lot);
}

/** @var string $page_content Contains html code */
$page_content = renderTemplate(
    'index',
    [
        'categories' => $categories,
        'lots' => $lots,
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
