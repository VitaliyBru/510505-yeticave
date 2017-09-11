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
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) . ' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) . ' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) . ' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

$page_content = renderTemplate(
        'lot',
        [
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
