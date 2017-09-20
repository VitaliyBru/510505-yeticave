<?php
$link = mysqli_connect('localhost', 'root', '', 'yeticave');
if (!$link) {
    $error = mysqli_connect_error($link);
    $page_content = renderTemplate('error', ['error' => $error]);
    echo renderTemplate(
        'layout',
        [
            'page_content' => $page_content,
            'is_auth' => false,
            'user_name' => '',
            'user_avatar' => '',
            'title' => 'Ошибка'
        ]
    );
    exit();
}