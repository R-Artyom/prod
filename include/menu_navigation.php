<?php

// Ссылка на страницу "Каталог(Главная)"
const PATH_CATALOG = '/';
// Ссылка на страницу "Новинки"
const PATH_CATALOG_NEW = '/catalog/new/';
//const PATH_CATALOG_NEW = '/products/new/';
// Ссылка на страницу "Распродажа"
const PATH_CATALOG_SALE = '/catalog/sale';
//const PATH_CATALOG_SALE = '/products/sale/';
// Ссылка на страницу "Список товаров"
const PATH_PRODUCTS_LIST = '/products/list/';
// Ссылка на страницу "Добавление товаров"
const PATH_PRODUCTS_ADD = '/products/add/';
// Ссылка на страницу "Изменение товаров"
const PATH_PRODUCTS_CHANGES = '/products/changes/';
// Ссылка на страницу "Список заказов"
const PATH_ORDERS_LIST = '/orders/list/';
// Ссылка на страницу "Оформление заказов"
const PATH_ORDERS_MAKE = '/orders/make/';
// Ссылка на страницу "О доставке"
const PATH_ORDERS_DELIVERY = '/orders/delivery/';
// Ссылка на страницу "Успешное создание заказа"
const PATH_ORDERS_SUCCESS = '/orders/success/';
// Ссылка на страницу "Вход в административный раздел (Авторизация)" / "Выход
// из административного раздела (Разавторизация)"
const PATH_ADMIN = '/admin/';
// Ссылка на страницу "Авторизация"
//const PATH_AUTHORIZATION = '/authorization/';
// Ссылка на страницу "Выход из административного раздела (Разавторизация)"
//const PATH_LOG_OUT = '/log_out/';

// Меню для пользователей
$menuNavigationUser = [
    [
        'title' => 'Главная', // Название пункта меню
        'path' => PATH_CATALOG, // Ссылка на страницу, куда ведет пункт меню
        'sort' => 1, // Индекс сортировки
    ],
    [
        'title' => 'Новинки',
        'path' => PATH_CATALOG_NEW,
        'sort' => 2,
    ],
    [
        'title' => 'Распродажа',
        'path' => PATH_CATALOG_SALE,
        'sort' => 3,
    ],
    [
        'title' => 'Доставка',
        'path' => PATH_ORDERS_DELIVERY,
        'sort' => 4,
    ],
    [
        'title' => 'Авторизация',
        'path' => PATH_ADMIN,
        'sort' => 5,
    ],
];

// Меню для группы "administrator"
$menuNavigationAdmin = [
    [
        'title' => 'Список товаров',
        'path' => PATH_PRODUCTS_LIST,
        'sort' => 1,
    ],
    [
        'title' => 'Добавление товаров',
        'path' => PATH_PRODUCTS_ADD,
        'sort' => 2,
    ],
    [
        'title' => 'Изменение товаров',
        'path' => PATH_PRODUCTS_CHANGES,
        'sort' => 3,
    ],
    [
        'title' => 'Список заказов',
        'path' => PATH_ORDERS_LIST,
        'sort' => 4,
    ],
    [
        'title' => 'Выход',
        'path' => PATH_ADMIN,
        'sort' => 5,
    ],
];

// Меню для группы "operator"
$menuNavigationOperator = [
    [
        'title' => 'Список заказов',
        'path' => PATH_ORDERS_LIST,
        'sort' => 1,
    ],
    [
        'title' => 'Выход',
        'path' => PATH_ADMIN,
        'sort' => 2,
    ],
];

// Меню для группы "another"
$menuNavigationAnother = [
    [
        'title' => 'Выход',
        'path' => PATH_ADMIN,
        'sort' => 1,
    ],
];

//$menuNavigation = [
//    [
//        'title' => 'Fashion', // Название пункта меню
//        'path' => PATH_CATALOG, // Ссылка на страницу, куда ведет пункт меню
//        'sort' => 1, // Индекс сортировки
//    ],
//    [
//        'title' => 'Новинки',
//        'path' => PATH_CATALOG_NEW,
//        'sort' => 2,
//    ],
//    [
//        'title' => 'Распродажа',
//        'path' => PATH_CATALOG_SALE,
//        'sort' => 3,
//    ],
//    [
//        'title' => 'Список товаров',
//        'path' => PATH_PRODUCTS_LIST,
//        'sort' => 4,
//    ],
//    [
//        'title' => 'Добавление товаров',
//        'path' => PATH_PRODUCTS_ADD,
//        'sort' => 5,
//    ],
//    [
//        'title' => 'Изменение товаров',
//        'path' => PATH_PRODUCTS_CHANGES,
//        'sort' => 6,
//    ],
//    [
//        'title' => 'Список заказов',
//        'path' => PATH_ORDERS_LIST,
//        'sort' => 7,
//    ],
//    [
//        'title' => 'Оформление заказов',
//        'path' => PATH_ORDERS_MAKE,
//        'sort' => 8,
//    ],
//    [
//        'title' => 'О доставке',
//        'path' => PATH_ORDERS_DELIVERY,
//        'sort' => 9,
//    ],
//    [
//        'title' => 'Успешное создание заказа',
//        'path' => PATH_ORDERS_SUCCESS,
//        'sort' => 10,
//    ],
//    [
//        'title' => 'Административный раздел',
//        'path' => PATH_ADMIN,
//        'sort' => 11,
//    ],
//];