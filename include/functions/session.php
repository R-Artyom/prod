<?php

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
    header ('Location:' . PATH_ACCOUNT_AUTHORIZATION);
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
