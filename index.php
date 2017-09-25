<?php
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

$sql_categories = 'SELECT * FROM categories';
$categories = select_data($link, $sql_categories);
$id = (int) ($_GET['id'] ?? null);
if ($id) {
    $sql_lots_count = 'SELECT COUNT(l.id) AS lots_count FROM lots AS l JOIN categories AS c ON l.category_id=c.id 
WHERE l.date_end > NOW() AND l.category_id=?';
    $lots_count = select_data($link, $sql_lots_count, [$id]);
    $sql_lot = 'SELECT l.id, l.name, l.image, l.price_start, l.date_end, c.name AS category FROM lots AS l 
    JOIN categories AS c ON l.category_id=c.id WHERE l.date_end > NOW() AND l.category_id=? ORDER BY l.id DESC LIMIT ? OFFSET ?';
    $pages = paginationCalculator($lots_count[0]['lots_count'], $_GET);
    $lots = select_data($link, $sql_lot, [$id, $pages['limit'], $pages['offset']]);
} else {
    $sql_lots_count = 'SELECT COUNT(id) AS lots_count FROM lots WHERE date_end > NOW()';
    $lots_count = select_data($link, $sql_lots_count);
    $sql_lot = 'SELECT l.id, l.name, l.image, l.price_start, l.date_end, c.name AS category FROM lots AS l 
    JOIN categories AS c ON l.category_id=c.id WHERE l.date_end > NOW() ORDER BY l.id DESC LIMIT ? OFFSET ?';
    $pages = paginationCalculator($lots_count[0]['lots_count'], $_GET);
    $lots = select_data($link, $sql_lot, [$pages['limit'], $pages['offset']]);
}

/** @var string $page_content Contains html code */
$page_content = renderTemplate('pagination', ['pages' => $pages, 'id' => $id]);
$page_content = renderTemplate(
    'index',
    [
        'page_content' => $page_content,
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
