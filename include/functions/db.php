<?php
/**
 * Функция устанавливает соединение с сервером MySQL
 * @return mysqli - данные установленного соединения
 */
function connectDb(): mysqli
{
    // Инициализация статической переменной
    static $connection = null;
    // Если соединение с сервером еще ни разу не устанавливалось
    if ($connection === null)
    {
        // Установить соединение с сервером MySQL
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // Если установить соединение не удалось
        if (mysqli_connect_errno()) {
            // Прервать выполнение скрипта
            exit();
        }
    }
    return $connection;
}

/**
 * Функция закрывает соединение с сервером MySQL
 * @param $connection - данные установленного соединения
 */
function disconnectDb(mysqli $connection)
{
    // Закрыть соединение c сервером MySQL
    mysqli_close($connection);
}

/**
 * Функция проверяет наличие пользователя в базе данных MySQL
 * @param $login - логин пользователя, который необходимо найти в базе
 * @param $password - пароль пользователя, который необходимо найти в базе
 * @return bool - результат проверки
 */
function verifyUserDb($login, $password): bool
{
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Экранирование данных
    $login = mysqli_real_escape_string($connection, $login);
    // Запрос к базе данных - поиск в таблице "users" пользователя с нужным логином
    $result = mysqli_query($connection, "SELECT * FROM users WHERE `email` = '$login'");
    // Преобразование результата запроса в ассоциативный массив "Профиль пользователя"
    $userProfile = mysqli_fetch_assoc($result);
    // Закрыть соединение с сервером MySQL
    disconnectDb($connection);
    // Возврат результата проверки пароля
    return isset($userProfile) && password_verify($password, $userProfile['password']);
}

/**
 * Функция запроса профиля пользователя по логину
 * @param $connection - данные установленного соединения
 * @param $login - логин пользователя, который необходимо найти в базе
 * @return array - результат проверки
 */
function getUserProfile(mysqli $connection, $login): array
{
    // Экранирование данных
    $login = mysqli_real_escape_string($connection, $login);
    // Запрос к базе данных - поиск в таблице "users" пользователя с нужным логином
    $result = mysqli_query($connection, "SELECT * FROM users WHERE `email` = '$login'");
    // Возврат ассоциативного массива "Профиль пользователя"
    return mysqli_fetch_assoc($result);
}