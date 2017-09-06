<?php
require_once 'functions.php';
$is_auth = (bool)rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$is_invalid = [
    'form' => false,
    'lot_name' => false,
    'category' => false,
    'message' => false,
    'lot_rate' => false,
    'lot_step' => false,
    'lot_date' => false
];

$lot_name = getFromPost($_POST, 'lot_name');
$category = getFromPost($_POST, 'category');
$message = getFromPost($_POST, 'message');
$lot_rate = getFromPost($_POST, 'lot_rate');
$lot_step = getFromPost($_POST, 'lot_step');
$lot_date = getFromPost($_POST, 'lot_date');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    setFlag($lot_name, '', 'lot_name', $is_invalid);
    setFlag($category, 'Выберите категорию', 'category', $is_invalid);
    setFlag($message, '', 'message', $is_invalid);
    if (!isStringNumber($lot_rate)) {
        $is_invalid['form'] = true;
        $is_invalid['lot_rate'] = true;
    }
    if (!isStringNumber($lot_step)) {
        $is_invalid['form'] = true;
        $is_invalid['lot_step'] = true;
    }
    if (!checkUserDate($lot_date)) {
        $is_invalid['form'] = true;
        $is_invalid['lot_date'] = true;
    }
    if (isset($_FILES) && !$is_invalid['form']) {
        $file_name = $_FILES['userImage']['name'];
        $file_path = __DIR__ . '/img/';
        $img_url = '/img/' . $file_name;
        move_uploaded_file($_FILES['userImage']['tmp_name'], $file_path . $file_name);
        $is_uploaded = true;
    } else {
        $is_invalid['form'] = true;
    }
}

if (!$is_uploaded) {
    $page_content = renderTemplate(
        'add-lot',
        [
            'is_invalid' => $is_invalid,
            'is_uploaded' => $is_uploaded,
            'lot_name' => $lot_name,
            'category' => $category,
            'message' => $message,
            'img_url' => $img_url,
            'lot_rate' => $lot_rate,
            'lot_step' => $lot_step,
            'lot_date' => $lot_date
        ]
    );
} else {
    $page_content = renderTemplate(
        'lot',
        [
            'lot_name' => $lot_name,
            'img_url' => $img_url,
            'category' => $category,
            'message' => $message,
            'lot_rate' => $lot_rate
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
?>