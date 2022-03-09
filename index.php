<?php

// Массив с описанием пунктов меню
require $_SERVER['DOCUMENT_ROOT'] . '/include/menu_navigation.php';
// Соединение c сервером MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
// Функции проверки авторизации пользователя
require $_SERVER['DOCUMENT_ROOT'] . '/include/authorization.php';
// Функции для вывода пунктов меню
require $_SERVER['DOCUMENT_ROOT'] . '/include/menu.php';

// Логика "Меню навигации"
require $_SERVER['DOCUMENT_ROOT'] . '/content/menu.php';

// Страницы:
// "Главная", "Новинки" или "Распродажа"
if (isCurrentUrl(PATH_CATALOG) || isCurrentUrl(PATH_CATALOG_NEW) || isCurrentUrl(PATH_CATALOG_SALE)) {
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
    require $_SERVER['DOCUMENT_ROOT'] . '/content/add.php';
    // Путь к шаблону страницы
    $pathTemplate = '/templates/add.php';
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
// Если пользователь аторизован
//if (isAuthorization()) {
//    // Если текущая страница "Профиль пользователя"
//    if (isCurrentUrl(PATH_USER_PROFILE)) {
//        // Логика страницы
//        require $_SERVER['DOCUMENT_ROOT'] . '/content/user_profile.php';
//    // Если текущая страница "Сообщения"
//    } else if (isCurrentUrl(PATH_POSTS)) {
//        // Логика страницы
//        require $_SERVER['DOCUMENT_ROOT'] . '/content/posts.php';
//    // Если текущая страница "Написать сообщение"
//    } else if (isCurrentUrl(PATH_POSTS_ADD)) {
//        // Логика страницы
//        require $_SERVER['DOCUMENT_ROOT'] . '/content/posts_add.php';
//    }
//}

// Шапка
require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

// Шаблон страницы
if (isset ($pathTemplate)) {
    require $_SERVER['DOCUMENT_ROOT'] . $pathTemplate;
}

//if (isCurrentUrl(PATH_CATALOG) || isCurrentUrl(PATH_CATALOG_NEW) || isCurrentUrl(PATH_CATALOG_SALE)) {
//    // "Главная"
//    include $_SERVER['DOCUMENT_ROOT'] . '/templates/catalog.php';
//} else if (isCurrentUrl(PATH_ADMIN)) {
//    // "Авторизация"
//    require $_SERVER['DOCUMENT_ROOT'] . '/templates/authorization.php';
//} else if (isCurrentUrl(PATH_ORDERS_DELIVERY)) {
//    // "О доставке"
//    require $_SERVER['DOCUMENT_ROOT'] . '/templates/delivery.php';
//}

// Подвал
require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';