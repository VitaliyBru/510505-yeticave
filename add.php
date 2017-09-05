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



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);
    if ($lot_name == '') {
        $is_invalid['form'] = true;
        $is_invalid['lot_name'] = true;
    }
    if ($category == 'Выберите категорию') {
        $is_invalid['form'] = true;
        $is_invalid['category'] = true;
    }
    if ($message == '') {
        $is_invalid['form'] = true;
        $is_invalid['message'] = true;
    }
    if (!isStringNumber($lot_rate)) {
        $is_invalid['form'] = true;
        $is_invalid['lot_rate'] = true;
    }
    if (!isStringNumber($lot_step)) {
        $is_invalid['form'] = true;
        $is_invalid['lot_step'] = true;
    }
    if (!isStrDate($lot_date)) {
        $is_invalid['form'] = true;
        $is_invalid['lot_date'] = true;
    } else {
        $date = new DateTime;
        $date = DateTime::createFromFormat('d.m.Y H:i:s', $lot_date . ' 00:00:00');
        if ($lot_date != $date->format('d.m.Y')) {
            $is_invalid['form'] = true;
            $is_invalid['lot_date'] = true;
        }
        if ($date->getTimestamp() < strtotime('now')) {
            $is_invalid['form'] = true;
            $is_invalid['lot_date'] = true;
        }
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
if (!isset($lot_name)) {
    $lot_name = '';
}
if (!isset($category)) {
    $category = '';
}
if (!isset($message)) {
    $message = '';
}
if (!isset($img_url)) {
    $img_url = '';
}
if (!isset($lot_rate)) {
    $lot_rate = '';
}
if (!isset($lot_step)) {
    $lot_step = '';
}
if (!isset($lot_date)) {
    $lot_date = '';
}
if (!isset($is_uploaded)) {
    $is_uploaded = false;
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
        'title' => 'Главная'
    ]
);
?>