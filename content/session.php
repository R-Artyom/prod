<?php

// Если существует кука 'session_id', значит сессия была запущена ранее
if (isset($_COOKIE[SESSION_NAME])) {
    // Установить имя сессии, как в куки, отличающееся от имени по умолчанию
    session_name(SESSION_NAME);
    // Старт сессии (продление)
    session_start();
    // Флаг - отсутствуют данные о сессии
    $flDataSessionError = (isset($_SESSION['startTime']) && isset($_SESSION['login'])) === false;
    // Флаг - время жизни сессии закончилось
    // Если время жизни сессии еще не закончилось, то переменная инициализируется значением false, иначе - true
    $flSessionTimeOut = (($_SESSION['startTime'] + TIME_OUT_SESSION) > time()) === false;
    // Если отсутствуют данные о сессии или время жизни сессии уже закончилось
    if ($flDataSessionError || $flSessionTimeOut) {
        // То необходимо разавторизировать пользователя и завершить сессию
        logOutAuthorization();
        // Если такой пользователь существует и время жизни сессии не закончилось
    } else {
        // Обновление времени начала сессии
        $_SESSION['startTime'] = time();
        // Создание куки с логином пользователя, длительностью месяц (31 день)
        setcookie('login', $_SESSION['login'], time() + TIME_OUT_LOGIN, '/');
    }
}