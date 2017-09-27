<?php
require_once 'vendor/autoload.php';
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

$sql_my_bets = 'SELECT lots.id, lots.name, lots.image, lots.date_end, lots.winner, bets.price, bets.date, categories.name AS category, users.contacts FROM bets 
INNER JOIN lots ON bets.lot_id=lots.id
INNER JOIN users ON lots.author=users.id
INNER JOIN categories ON lots.category_id=categories.id
WHERE bets.price IN (SELECT MAX(price) FROM bets WHERE user_id=? GROUP BY lot_id)';
$my_bets = select_data($link, $sql_my_bets, [$user_id]);
$categories = getCategoriesList($link);

$page_content = renderTemplate(
    'mylots',
    [
        'user_id' => $user_id,
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