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
if (isset($_SESSION['username'])) {
    $is_auth = true;
    $user_name = $_SESSION['username'];
    $user_avatar = 'img/user.jpg';
}

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
// ...
$delta_time_h = floor(($tomorrow - $now) / 3600);
$delta_time_m = floor(($tomorrow - $now) % 3600 / 60);
$lot_time_remaining = sprintf("%02d:%02d", $delta_time_h, $delta_time_m);

/** @var string $page_content Contains html code */
$page_content = renderTemplate(
    'index',
    [
        'goods_type' => $goods_type,
        'lots_list' => $lots_list,
        'lot_time_remaining' => $lot_time_remaining
    ]
);
echo renderTemplate(
    'layout',
    [
        'page_content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'user_avatar' => $user_avatar,
        'title' => 'Главная'
    ]
);
