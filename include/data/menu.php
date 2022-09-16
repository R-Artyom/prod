<?php
/**
 * Ссылки пунктов меню навигации
 */
// Ссылка на страницу "Главная"
const PATH_MAIN = '/';
// Ссылка на страницу "Каталог"
const PATH_CATALOG = '/catalog/';
// Ссылка на страницу "Новинки"
const PATH_CATALOG_NEW = '/catalog/new/';
// Ссылка на страницу "Распродажа"
const PATH_CATALOG_SALE = '/catalog/sale/';
// Ссылка на страницу "Список товаров"
const PATH_PRODUCTS_LIST = '/admin/products/list/';
// Ссылка на страницу "Добавление товаров"
const PATH_PRODUCTS_ADD = '/admin/products/add/';
// Ссылка на страницу "Список заказов"
const PATH_ORDERS_LIST = '/admin/orders/list/';
// Ссылка на страницу "О доставке"
const PATH_ORDERS_DELIVERY = '/orders/delivery/';
// Ссылка на страницу "Авторизация (вход в аккаунт / выход их аккауна)"
const PATH_ACCOUNT_AUTHORIZATION = '/account/authorization/';
/**
 * Ссылки на категории товаров
 */
// Ссылка на страницу "Все категории товаров"
const PATH_ALL = 'all/';
// Ссылка на страницу категории товаров "Женщины"
const PATH_WOMAN = 'woman/';
// Ссылка на страницу категории товаров "Мужчины"
const PATH_MAN = 'man/';
// Ссылка на страницу категории товаров "Дети"
const PATH_CHILDREN = 'children/';
// Ссылка на страницу категории товаров "Аксессуары"
const PATH_ACCESSORIES = 'accessories/';
// Всё в одном массиве
const PATH_CATEGORIES = [PATH_ALL, PATH_WOMAN, PATH_MAN, PATH_CHILDREN, PATH_ACCESSORIES];

// Меню для всех незарегистрированных пользователей
$menuNavigationUser = [
    [
        'title' => 'Главная', // Название пункта меню
        'path' => PATH_MAIN, // Ссылка на страницу, куда ведет пункт меню
        'pathLevel1' => ['catalog/'], // Первый уровень вложенности директории
        'pathLevel2' => PATH_CATEGORIES, // Второй уровень вложенности директории
    ],
    [
        'title' => 'Новинки',
        'path' => PATH_CATALOG_NEW,
        'pathLevel1' => PATH_CATEGORIES,
    ],
    [
        'title' => 'Распродажа',
        'path' => PATH_CATALOG_SALE,
        'pathLevel1' => PATH_CATEGORIES,
    ],
    [
        'title' => 'Доставка',
        'path' => PATH_ORDERS_DELIVERY,
    ],
    [
        'title' => 'Авторизация',
        'path' => PATH_ACCOUNT_AUTHORIZATION,
    ],
];

// Меню для группы "operator"
$menuNavigationOperator = [
    [
        'title' => 'Заказы',
        'path' => PATH_ORDERS_LIST,
    ],
    [
        'title' => 'Выйти',
        'path' => PATH_ACCOUNT_AUTHORIZATION,
    ],
];

// Меню для группы "administrator"
$menuNavigationAdministrator = [
    [
        'title' => 'Заказы',
        'path' => PATH_ORDERS_LIST,
    ],
    [
        'title' => 'Товары',
        'path' => PATH_PRODUCTS_LIST,
    ],
    [
        'title' => 'Добавление товара',
        'path' => PATH_PRODUCTS_ADD,
    ],
    [
        'title' => 'Выйти',
        'path' => PATH_ACCOUNT_AUTHORIZATION,
    ],
];

// Меню для группы "another" (пользователь, не обладающий правами админимтратора
// и оператора, но авторизированный)
$menuNavigationAnother = [
    [
        'title' => 'Выйти',
        'path' => PATH_ACCOUNT_AUTHORIZATION,
    ],
];