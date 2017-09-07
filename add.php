<?php
require_once 'functions.php';
$is_auth = (bool)rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

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
    if (!isset($_FILES) || !$form_valid) {
        $form_valid = false;
    } elseif (!array_key_exists('userImage', $_FILES)) {
        $form_valid = false;
    } elseif ($_FILES['userImage']['name'] != '') {
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
    $page_content = renderTemplate(
        'lot',
        [
            'lot_name' => $add_item_form['lot_name']['value'],
            'img_url' => $add_item_form['img_url']['value'],
            'category' => $add_item_form['category']['value'],
            'message' => $add_item_form['message']['value'],
            'lot_rate' => $add_item_form['lot_rate']['value']
        ]
    );
} else {
    $page_content = renderTemplate('add-lot', ['add_item_form' => $add_item_form, 'form_valid' => $form_valid]);
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