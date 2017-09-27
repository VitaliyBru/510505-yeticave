<?php
require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

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

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$categories = getCategoriesList($link);
$first_visit = true;
$add_lot = [
    'value' => ['name' => '', 'category' => '', 'description' => '', 'price_start' => '', 'price_increment' => '', 'date_end' => '', 'image' => ''],
    'errors' => 0
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_visit = false;
    $add_lot = getDataAddLotForm($_POST, $categories);
    if (isset($_FILES) && array_key_exists('userImage', $_FILES) && $_FILES['userImage']['name'] != '') {
        if ($add_lot['value']['image'] = getImageFilePostForm($_FILES)) {
            $add_lot['errors']--;
        }
    }
    if (!$add_lot['errors']) {
        $key = in_array($add_lot['value']['category'], array_column($categories, 'name'));
        $add_lot['value']['category_id'] = $categories[$key]['id'];
        unset($add_lot['value']['category']);
        $add_lot['value']['author'] = $user_id;
        if ($new_lot_id = insert_data($link, 'lots', $add_lot['value'])) {
            header("location: /lot.php?lot_id=$new_lot_id");
            exit();
        } else{
            echo 'Ошибка добавления в БД';
            exit();
        }
    }
}

$page_content = renderTemplate(
    'add',
    [
        'add_lot' => $add_lot,
        'categories' => $categories
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
        'title' => 'Добавление лота'
    ]
);