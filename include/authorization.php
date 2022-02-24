<?php

// Имя сессии сайта
define('SESSION_NAME', 'session_id');
// Время жизни сессии
define('TIME_OUT_SESSION', 60 * 20); // 20 минут
// Время жизни куки с логином
define('TIME_OUT_LOGIN', 60 * 60 * 24 * 31); // 31 день

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

/**
* Функция определения авторизации пользователя
* @return bool возвращает результат
*/
function isAuthorization(): bool
{
    return isset($_SESSION['login']);
}

/**
* Функция разавторизации пользователя
*/
function logOutAuthorization()
{
    // Удаление временного хранилища на сервере
    session_destroy();
    // Очистка массива $_SESSION
    unset($_SESSION['startTime']);
    unset($_SESSION['login']);
    // Удаление сессионного куки на сервере
    unset($_COOKIE[SESSION_NAME]);
    // Удаление сессионного куки в браузере
    setcookie(SESSION_NAME, '', 1, '/');
    // Перенаправление на страницу авторизации
    header ('Location:' . PATH_ADMIN);
    // Прерывание выполнения скрипта
    exit();
}

/**
 * Функция смены профиля пользователя
 */
function changeUserProfile()
{
    // Удаление куки с логином пользователя на сервере
    unset($_COOKIE['login']);
    // Удаление куки с логином пользователя в браузере
    setcookie('login', '', 1, '/');
    // Перенаправление на страницу авторизации
    header('Location: /?login=yes');
    // Прерывание выполнения скрипта
    exit();
}
