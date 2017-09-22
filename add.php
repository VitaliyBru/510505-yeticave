<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'lots_list.php';

/** @var bool $is_auth is true if user are authorized */
$is_auth = false;
/** @var string $user_name */
$user_name = null;
/** @var string $user_avatar contains a path to user avatar image */
$user_avatar = null;
session_start();
if (isset($_SESSION['username'])) {
    $is_auth = true;
    $user_name = $_SESSION['username'];
    $user_avatar = 'img/user.jpg';
} else {
    http_response_code(403);
    echo 'ошибка 403';
    exit();
}

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$first_visit = true;
$add_lot = ['name' => '', 'category' => '', 'description' => '', 'price_start' => '', 'price_step' => '', 'date_end' => '', 'img_url' => '', 'errors' => 0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_visit = false;
    $add_lot = getDataAddLotForm($_POST, $categories);
    if (isset($_FILES) && array_key_exists('userImage', $_FILES) && $_FILES['userImage']['name'] != '') {
        if ($add_lot['img_url'] = getImageFilePostForm($_FILES)) {
            $add_lot['errors']--;
        }
    }
}

if ( !$add_lot['errors'] && !$first_visit) {
    $new_lot_id = count($lots);
    foreach ($add_lot as $key => $value) {
        if ($key != 'errors') {
            $lots[$new_lot_id][$key] = $value;
        }
    }
    $page_content = renderTemplate(
        'lot',
        [
            'bets' => $bets,
            'lot_id' => $new_lot_id,
            'bet_done' => true,
            'lots' => $lots,
            'is_auth' => $is_auth
        ]
    );
} else {
    $page_content = renderTemplate(
        'add',
        [
            'add_lot' => $add_lot,
            'categories' => $categories
        ]
    );
}

echo renderTemplate(
    'layout',
    [
        'page_content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'user_avatar' => $user_avatar,
        'title' => 'Добавление лота'
    ]
);