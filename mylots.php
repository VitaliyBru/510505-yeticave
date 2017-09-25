<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

define('SECONDS_IN_DAY', '86400');

date_default_timezone_set('Europe/Moscow');

/** @var bool $is_auth is true if user are authorized */
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
} else {
    http_response_code(403);
    echo 'ошибка 403';
    exit();
}

$sql_my_bets = 'SELECT bl.id, bl.price, bl.date, bl.lot_id, bl.image, bl.name, bl.date_end, 
bl.winner, c.name AS category, u.contacts FROM (SELECT b.id, b.price, b.date, l.id AS lot_id, l.image, l.name, l.date_end, 
l.winner, l.category_id FROM (SELECT id, MAX(price) AS price, lot_id, date FROM bets WHERE user_id=? GROUP BY lot_id) AS b 
JOIN lots AS l ON b.lot_id=l.id) AS bl JOIN categories AS c ON bl.category_id=c.id LEFT JOIN users AS u ON bl.winner=u.id 
ORDER BY bl.id DESC';
$my_bets = select_data($link, $sql_my_bets, [$user_id]);
$categories = select_data($link, 'SELECT * FROM categories');

$page_content = renderTemplate(
    'mylots',
    [
        'my_bets' => $my_bets,
        'categories' => $categories,
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
        'title' => 'Мои ставки'
    ]
);