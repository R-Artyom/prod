<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Fashion</title>

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="/img/intro/coats-2018.jpg" as="image">
    <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="/img/favicon.png">
    <link rel="stylesheet" href="/css/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="/js/scripts.js" defer=""></script>
    <script src="/js/ajax/products_add.js"></script>
    <script src="/js/ajax/order_add.js"></script>

</head>
<body>
<header class="page-header">
    <a class="page-header__logo" href="<?=PATH_MAIN?>">
        <img src="/img/logo.svg" alt="Fashion">
    </a>
    <nav class="page-header__menu">
        <ul class="main-menu main-menu--header">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php';?>
        </ul>
    </nav>
</header>