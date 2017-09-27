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
/** @var bool $bet_block_hidden if true then the block will be hidden*/
$bet_block_hidden = true;
session_start();
if (isset($_SESSION['user'])) {
    $is_auth = true;
    $user_name = $_SESSION['user']['name'];
    $user_id = $_SESSION['user']['id'];
    $user_avatar = $_SESSION['user']['avatar'];
    $bet_block_hidden = false;
}

/** @var int $lot_id Contains lot identification number */
$lot_id = $_GET['lot_id'] ?? null;
$sql_lot = 'SELECT l.id, l.name, l.description, l.image, l.price_start, l.price_increment, l.date_end, l.author, c.name AS category 
FROM lots AS l 
JOIN categories AS c ON l.category_id=c.id 
WHERE l.id=?';
/** @var array $lot_bet a two dimension array contains information about bets */
$lot_bet = select_data($link, $sql_lot, [$lot_id]);
if (!$lot_bet){
    http_response_code(404);
    echo 'ошибка 404';
    exit();
}
$lot = $lot_bet[0];
if ($lot['author'] == $user_id) {
    $bet_block_hidden = true;
}
/** @var string $sql_bets a mysql query*/
$sql_bets = 'SELECT b.price, b.date, u.name  
FROM bets AS b 
LEFT JOIN users AS u ON b.user_id = u.id 
WHERE b.lot_id=? 
ORDER BY b.id DESC';
$bets = select_data($link, $sql_bets, [$lot_id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('cost', $_POST)) {
    $bet_min = $bets[0]['price'] ? ($bets[0]['price'] + $lot['price_increment']) : $lot['price_start'];
    $bet_amount = $_POST['cost'];
    if ($bet_amount >= $bet_min && (int) $bet_amount == $bet_amount) {
        $my_bet = [
            'lot_id' => $lot['id'],
            'user_id' => $user_id,
            'price' => $_POST['cost'],
        ];
        if (insert_data($link,'bets', $my_bet)) {
            header('location: /mylots.php');
            exit();
        } else {
            echo 'Ошибка добавления ставки в БД';
            exit();
        }
    } else {
        echo 'Ставка слишком мала';
        exit();
    }
}

$categories = getCategoriesList($link);
$page_content = renderTemplate(
        'lot',
        [
            'bets' => $bets,
            'lot' => $lot,
            'categories' => $categories,
            'bet_block_hidden' => $bet_block_hidden
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
        'title' => htmlspecialchars($lot_bet[$lot_id]['name'])
    ]
);
