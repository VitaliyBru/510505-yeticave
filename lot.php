<?php
require_once 'functions.php';
require_once 'lots_list.php';

define('SECONDS_IN_DAY', '86400');

date_default_timezone_set('Europe/Moscow');

session_start();
if (isset($_SESSION['username'])) {
    $is_auth = true;
    $user_name = $_SESSION['username'];
    $user_avatar = 'img/user.jpg';
} else {
    $is_auth = false;
}

/** @var int $lot_id Contains lot identification number */
$lot_id = $_GET['lot_id'] ?? null;
if (!array_key_exists($lot_id, $lots_list)){
    http_response_code(404);
    echo 'ошибка 404';
    exit();
}

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) . ' hour')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) . ' hour')],
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) . ' minute')],
];


/** @var array $my_bets */
$my_bets = [];
if (isset($_COOKIE['my_bets'])) {
    $my_bets = json_decode($_COOKIE['my_bets'], true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('cost', $_POST)) {
    $my_bets[$lot_id] = [
        'name' => $user_name,
        'price' => $_POST['cost'],
        'ts' => strtotime('now')
    ];
    $json_bets = json_encode($my_bets);
    $bet_done = true;
    header('location: /mylots.php');
    setcookie('my_bets', $json_bets, time() + 1800);
    exit();
}

/** @var bool $bet_done True if the bet is done */
$bet_done = false;
if (array_key_exists($lot_id, $my_bets)) {
    $new_bet_id = count($bets);
    $bets[$new_bet_id] = ['name' => $my_bets[$lot_id]['name'], 'price' => $my_bets[$lot_id]['price'], 'ts' => $my_bets[$lot_id]['ts']];
    $bet_done = true;
}
$bets = array_reverse($bets, true);

$page_content = renderTemplate(
        'lot',
        [
            'bet_done' => $bet_done,
            'bets' => $bets,
            'lot_id' => $lot_id,
            'lots_list' => $lots_list,
            'is_auth' => $is_auth
        ]
);
echo renderTemplate(
    'layout',
    [
        'page_content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'user_avatar' => $user_avatar,
        'title' => htmlspecialchars($lots_list[$lot_id]['lot_name'])
    ]
);

?>
