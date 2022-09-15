<?php
/**
 * Данные
 */
// Сессия
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/session.php';
// Пункты меню
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/menu.php';
// База данных MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/db.php';
// Доставка товара
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/delivery.php';
/**
 * Функции
 */
// Сессия
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/session.php';
// Пункты меню
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/menu.php';
// База данных MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/db.php';
// Постраничная навигация
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/pagination.php';
// Формирование фраз
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/phrase.php';
/**
 * Логика
 */
// Сессия
require $_SERVER['DOCUMENT_ROOT'] . '/content/session.php';
// Пункты меню
require $_SERVER['DOCUMENT_ROOT'] . '/content/menu.php';

// Страницы:
// "Главная", "Новинки" или "Распродажа"
if (isCurrentUrl(PATH_MAIN)
    || (strpos($_SERVER["REQUEST_URI"], PATH_CATALOG) === 0)) {
    // Логика страницы
    require $_SERVER['DOCUMENT_ROOT'] . '/content/catalog.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/catalog.php';
// "Список заказов"
} else if (isCurrentUrl(PATH_ORDERS_LIST)) {
    // Логика страницы
    require $_SERVER['DOCUMENT_ROOT'] . '/content/orders.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/orders.php';
// "Список товаров"
} else if (isCurrentUrl(PATH_PRODUCTS_LIST)) {
    // Логика страницы
    require $_SERVER['DOCUMENT_ROOT'] . '/content/products.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/products.php';
// "Добавление товара"
} else if (isCurrentUrl(PATH_PRODUCTS_ADD)) {
    // Логика страницы
    require $_SERVER['DOCUMENT_ROOT'] . '/content/products_add.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/products_add.php';
// "О доставке"
} else if (isCurrentUrl(PATH_ORDERS_DELIVERY)) {
    // Логика страницы
    require $_SERVER['DOCUMENT_ROOT'] . '/content/delivery.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/delivery.php';
// "Авторизация"
} else if (isCurrentUrl(PATH_ACCOUNT_AUTHORIZATION)) {
    // Логика страницы
    require $_SERVER['DOCUMENT_ROOT'] . '/content/authorization.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/authorization.php';
}

// Шапка
require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

// Шаблон страницы
if (isset ($pathTemplate)) {
    require $_SERVER['DOCUMENT_ROOT'] . $pathTemplate;
}

// Подвал
require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';