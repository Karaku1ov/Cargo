<?php
$services = [
    "avia" => [
        "title" => "Авиа доставка",
        "desc" => "Самый быстрый способ перевозки грузов по всему миру.",
        "img" => "img/1.jpg",
        "price" => "2500 руб."
    ],
    "freight" => [
        "title" => "Грузоперевозки",
        "desc" => "Перевозка товаров на дальние расстояния с минимальными затратами.",
        "img" => "img/2.jpg",
        "price" => "1200 руб."
    ],
    "sea" => [
        "title" => "Морская доставка",
        "desc" => "Экономичный способ доставки крупных партий товаров.",
        "img" => "img/3.jpg",
        "price" => "1500 руб."
    ],
    "rail" => [
        "title" => "Железнодорожная доставка",
        "desc" => "Надежный способ доставки грузов по суше.",
        "img" => "img/4.jpg",
        "price" => "850 руб."
    ],
    "courier" => [
        "title" => "Курьерская служба",
        "desc" => "Быстрая доставка посылок и документов.",
        "img" => "img/5.jpg",
        "price" => "250 руб."
    ]
];

if (!function_exists('getServiceById')) {
    function getServiceById($id) {
        global $services;
        return $services[$id] ?? null;
    }
}
?>