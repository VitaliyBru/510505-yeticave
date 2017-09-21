<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'lots_list.php';

define('SECONDS_IN_DAY', '86400');

date_default_timezone_set('Europe/Moscow');

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

$my_bets = [];
if (isset($_COOKIE['my_bets'])) {
    $my_bets = json_decode($_COOKIE['my_bets'], true);
    if (count($my_bets) > 1) {
        $my_bets = array_reverse($my_bets, true);
    }
}

$page_content = renderTemplate(
    'mylots',
    [
        'my_bets' => $my_bets,
        'lots' => $lots
    ]
);
echo renderTemplate(
    'layout',
    [
        'page_content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'user_avatar' => $user_avatar,
        'title' => 'Мои ставки'
    ]
);