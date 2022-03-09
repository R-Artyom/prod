<!--<!DOCTYPE html>-->
<!--<html lang="ru">-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <title>Авторизация</title>-->
<!---->
<!--    <meta name="description" content="Fashion - интернет-магазин">-->
<!--    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">-->
<!---->
<!--    <meta name="theme-color" content="#393939">-->
<!---->
<!--    <link rel="preload" href="../../prod/fonts/opensans-400-normal.woff2" as="font">-->
<!--    <link rel="preload" href="../../prod/fonts/roboto-400-normal.woff2" as="font">-->
<!--    <link rel="preload" href="../../prod/fonts/roboto-700-normal.woff2" as="font">-->
<!---->
<!--    <link rel="icon" href="../../prod/img/favicon.png">-->
<!--    <link rel="stylesheet" href="../../prod/css/style.min.css">-->
<!---->
<!--    <script src="../../prod/js/scripts.js" defer=""></script>-->
<!--</head>-->
<!--<body>-->
<!--<header class="page-header">-->
<!--    <a class="page-header__logo" href="#">-->
<!--        <img src="../../prod/img/logo.svg" alt="Fashion">-->
<!--    </a>-->
<!--    <nav class="page-header__menu">-->
<!--        <ul class="main-menu main-menu--header">-->
<!--            <li>-->
<!--                <a class="main-menu__item" href="/">Главная</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="main-menu__item" href="#">Новинки</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="main-menu__item" href="../../prod/index.php">Sale</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="main-menu__item" href="../../prod/delivery.php">Доставка</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </nav>-->
<!--</header>-->
<main class="page-authorization">
    <h1 class="h h--1"><?=$title?></h1>
    <form class="custom-form" action="<?=PATH_ACCOUNT_AUTHORIZATION?>" method="post">
        <?php if (isAuthorization()): ?>
            <span id="gray">Ваш e-mail: <b><?= $_SESSION['login'] ?></b><br/><br/></span>
            <?php if (isset($flLogInSuccess) && $flLogInSuccess): ?>
                <span id="success"><?php include $_SERVER['DOCUMENT_ROOT'] . '/include/success.php'; ?><br/><br/></span>
            <?php endif ?>
            <input class="button" type="submit" name="log_out" value="Выйти">
        <?php elseif (isset($isShowErrorLogIn) && $isShowErrorLogIn): ?>
            <span id="success"><?php include $_SERVER['DOCUMENT_ROOT'] . '/include/error.php'; ?><br/><br/></span>
            <input type="email" name="login" class="custom-form__input" placeholder="Ваш e-mail" value="<?= htmlspecialchars($loginError) ?>" required="">
            <input type="password" name="password" class="custom-form__input" placeholder="Ваш пароль" value="<?= htmlspecialchars($passwordError) ?>" required="">
            <button class="button" type="submit">Войти в личный кабинет</button>
        <?php else: ?>
            <input type="email" name="login" class="custom-form__input" placeholder="Ваш e-mail" required="">
            <input type="password" name="password" class="custom-form__input" placeholder="Ваш пароль" required="">
            <button class="button" type="submit">Войти в личный кабинет</button>
        <?php endif ?>
    </form>
</main>



<!--<footer class="page-footer">-->
<!--    <div class="container">-->
<!--        <a class="page-footer__logo" href="#">-->
<!--            <img src="../../prod/img/logo--footer.svg" alt="Fashion">-->
<!--        </a>-->
<!--        <nav class="page-footer__menu">-->
<!--            <ul class="main-menu main-menu--footer">-->
<!--                <li>-->
<!--                    <a class="main-menu__item" href="#">Главная</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a class="main-menu__item" href="#">Новинки</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a class="main-menu__item" href="../../prod/index.php">Sale</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a class="main-menu__item" href="../../prod/delivery.php">Доставка</a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </nav>-->
<!--        <address class="page-footer__copyright">-->
<!--            © Все права защищены-->
<!--        </address>-->
<!--    </div>-->
<!--</footer>-->
<!--</body>-->
<!--</html>-->
