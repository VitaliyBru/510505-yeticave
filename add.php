<?php
require_once 'functions.php';
require_once 'lots_list.php';

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

$form_valid = true;
$add_item_form = [
    'lot_name' => ['value' => '', 'require' => 'not empty', 'valid' => true],
    'category' => ['value' => '', 'require' => 'choice', 'valid' => true],
    'message' => ['value' => '', 'require' => 'not empty', 'valid' => true],
    'lot_rate' => ['value' => '', 'require' => 'number', 'valid' => true],
    'lot_step' => ['value' => '', 'require' => 'number', 'valid' => true],
    'lot_date' => ['value' => '', 'require' => 'date', 'valid' => true],
    'img_url' => ['value' => '', 'require' => 'upload', 'valid' => false]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($add_item_form as $key => $section) {
        $add_item_form[$key] = addFormToArray($_POST, $key, $section);
        if (!$add_item_form[$key]['valid'] && $key != 'img_url') {
            $form_valid = false;
        }
    }
    if ($form_valid && isset($_FILES) && array_key_exists('userImage', $_FILES) && $_FILES['userImage']['name'] != '') {
        $file_name = $_FILES['userImage']['name'];
        $file_path = __DIR__ . '/img/';
        $add_item_form['img_url']['value'] = '/img/' . $file_name;
        move_uploaded_file($_FILES['userImage']['tmp_name'], $file_path . $file_name);
        $add_item_form['img_url']['valid'] = true;
    } else {
        $form_valid = false;
    }
}

if ($add_item_form['img_url']['valid']) {
    $lot_id = count($lots_list);
    foreach ($add_item_form as $key => $section) {
        $lots_list[$lot_id][$key] = $section['value'];
    }
    $page_content = renderTemplate(
        'lot',
        [
            'bets' => $bets,
            'lot_id' => $lot_id,
            'bet_done' => true,
            'lots_list' => $lots_list,
            'is_auth' => $is_auth
        ]
    );
} else {
    $page_content = renderTemplate(
        'add',
        [
            'add_item_form' => $add_item_form,
            'form_valid' => $form_valid,
            'goods_type' => $goods_type
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