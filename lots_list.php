<?php
/** @var array $categories the array contains a list of goods type */
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
/** @var array $lots the array contains information list about lots (item, type, price, URL img) */
$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price_start' => '10999',
        'img_url' => 'img/lot-1.jpg',
        'date_end' => strtotime('tomorrow midnight'),
        'description' => '---Описпние не предоставлено---',
        'price_step' => null
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price_start' => '159999',
        'img_url' => 'img/lot-2.jpg',
        'date_end' => strtotime('tomorrow midnight'),
        'description' => 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком
        и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью 
        и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать 
        высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску 
        и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'price_step' => null
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price_start' => '8000',
        'img_url' => 'img/lot-3.jpg',
        'date_end' => strtotime('tomorrow midnight'),
        'description' => '---Описпние не предоставлено---',
        'price_step' => null
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price_start' => '10999',
        'img_url' => 'img/lot-4.jpg',
        'date_end' => strtotime('tomorrow midnight'),
        'description' => '---Описпние не предоставлено---',
        'price_step' => null
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price_start' => '7500',
        'img_url' => 'img/lot-5.jpg',
        'date_end' => strtotime('tomorrow midnight'),
        'description' => '---Описпние не предоставлено---',
        'price_step' => null
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price_start' => '5400',
        'img_url' => 'img/lot-6.jpg',
        'date_end' => strtotime('tomorrow midnight'),
        'description' => '---Описпние не предоставлено---',
        'price_step' => null
    ]
];

$bets = [
    ['name' => '', 'price' => '', 'ts' => null, 'lot_id' => null]
];
?>