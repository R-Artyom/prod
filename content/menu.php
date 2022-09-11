<?php
// Определение группы пользователя
if (isAuthorization())
{
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Считывание названия текущей базы данных
    $result = mysqli_query($connection, "SELECT DATABASE()");
    $dbName = mysqli_fetch_assoc($result);

    // Формирование массива "Профиль пользователя"
    $userProfile = getUserProfile($connection, $_SESSION['login']);

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
    // Закрыть соединение с сервером MySQL (Только в том случае, если соединение
    // больше не будет использоваться!!!)
    //disconnectDb($connection);

    //var_dump($userGroup);

    // Определение меню навигации в соответствии с группой
    $menuNavigation = $menuNavigationAnother;
    $statusUser = 'Не определён';
    foreach ($userGroup as $value) {
        // Администратор
        if ($value['name'] === 'administrator') {
            $menuNavigation = $menuNavigationAdministrator;
            $statusUser = 'Администратор';
            break;
        }
        // Оператор
        if ($value['name'] === 'operator') {
            $menuNavigation = $menuNavigationOperator;
            $statusUser = 'Оператор';
            break;
        }
    }
} else {
    // Обычный пользователь
    $menuNavigation = $menuNavigationUser;
    $statusUser = 'Пользователь';
}

// Определение заголовка страницы
$title = findTitle($menuNavigation);

// Определение активной страницы
$urlActive = findUrlActive($menuNavigation);