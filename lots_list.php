<?php
/** @var array $goods_type the array contains a list of goods type */
$goods_type = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
/** @var array $lots_list the array contains information list about lots (item, type, price, URL img) */
$lots_list = [
    [
        'lot_name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'lot_rate' => '10999',
        'img_url' => 'img/lot-1.jpg',
        'lot_date' => strtotime('tomorrow midnight'),
        'message' => '---Описпние не предоставлено---',
        'lot_step' => null
    ],
    [
        'lot_name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'lot_rate' => '159999',
        'img_url' => 'img/lot-2.jpg',
        'lot_date' => strtotime('tomorrow midnight'),
        'message' => 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком
        и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью 
        и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать 
        высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску 
        и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'lot_step' => null
    ],
    [
        'lot_name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'lot_rate' => '8000',
        'img_url' => 'img/lot-3.jpg',
        'lot_date' => strtotime('tomorrow midnight'),
        'message' => '---Описпние не предоставлено---',
        'lot_step' => null
    ],
    [
        'lot_name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'lot_rate' => '10999',
        'img_url' => 'img/lot-4.jpg',
        'lot_date' => strtotime('tomorrow midnight'),
        'message' => '---Описпние не предоставлено---',
        'lot_step' => null
    ],
    [
        'lot_name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'lot_rate' => '7500',
        'img_url' => 'img/lot-5.jpg',
        'lot_date' => strtotime('tomorrow midnight'),
        'message' => '---Описпние не предоставлено---',
        'lot_step' => null
    ],
    [
        'lot_name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'lot_rate' => '5400',
        'img_url' => 'img/lot-6.jpg',
        'lot_date' => strtotime('tomorrow midnight'),
        'message' => '---Описпние не предоставлено---',
        'lot_step' => null
    ]
];

$bets = [
    ['name' => '', 'price' => '', 'ts' => null, 'lot_id' => null]
];
?>