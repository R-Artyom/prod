<?php
/**
 * Страница с отображением в виде списка всех полей пользователя, а также всех
 * групп, к которым этот пользователь принадлежит.
 */

// Путь к шаблону страницы
$pathTemplate = '/templates/user_profile.php';

// Установить соединение с сервером MySQL
$connection = connectDb();
// Считывание названия текущей базы данных
$result = mysqli_query($connection, "SELECT DATABASE()");
$dbName = mysqli_fetch_assoc($result);

// Формирование массива "Профиль пользователя"
$userProfile = getUserProfile($connection, $_SESSION['login']);

// Формирование массива "Названия столбцов"
// Запрос к базе данных - считывание названий столбцов таблицы "users"
$result = mysqli_query(
    $connection,
    "SELECT COLUMN_NAME FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA = '{$dbName['DATABASE()']}' AND TABLE_NAME='users'"
);
// Добавление результата в многомерный массив "Названия столбцов"
$userColumnNames = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Формирование массива "Комментарии к назавиям столбцов"
// Запрос к базе данных - считывание комментариев к названиям столбцов таблицы "users"
$result = mysqli_query(
    $connection,
    "SELECT COLUMN_COMMENT FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA = '{$dbName['DATABASE()']}' AND TABLE_NAME='users'"
);
// Добавление результата в многомерный массив "Комментарии к назавиям столбцов"
$userColumnComments = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Формирование массива "Профиль пользователя с описанием столбцов"
// Если существуют массив с названиями столбцов и массив с комментариями
if (isset($userColumnNames) && isset($userColumnComments)) {
    // Создание многомерного массива "Профиль пользователя с описанием столбцов"
    foreach ($userColumnNames as $key => $value) {
        // Параметр (комментарий к названию столбца)
        $userMultiProfile[$key]['comment'] = $userColumnComments[$key]['COLUMN_COMMENT'];
        // Содержимое ячейка столбца
        $userMultiProfile[$key]['data'] = $userProfile[$value['COLUMN_NAME']];
    }
}

// Формирование массива "Группы, в которые входит пользователь, с описанием"
// Запрос к базе данных - поиск в таблице "group_user" пользователя по идентификационному номеру
// и если такой есть, то взятие из таблицы "groups" названия группы (куда входит пользователь) и её описание
$result = mysqli_query(
    $connection,
    "SELECT `groups`.name, `groups`.description FROM users
        LEFT JOIN group_user on users.id = group_user.user_id
            LEFT JOIN `groups` on group_user.group_id = `groups`.id WHERE group_user.user_id = '{$userProfile['id']}'"
);
// Добавление результата в многомерный массив "Группы, в которые входит пользователь"
$userGroup = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Закрыть соединение с сервером MySQL
disconnectDb($connection);
