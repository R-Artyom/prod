<?php
/**
 * Страница с отображением в виде списка всех сообщений пользователя
 */

// Путь к шаблону страницы
$pathTemplate = '/templates/posts.php';

// Флаг - отобразить список сообщений или одно сообщение полностью
$showMessage = false;
// Установить соединение с сервером MySQL
$connection = connectDb();

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
// Считывание результата в массив до тех пор, пока он выдаётся
while ($arr = mysqli_fetch_assoc($result)) {
    // Если пользователь входит в группу "Зарегистрированный пользователь, имеющий право писать сообщения
    if ($arr['name'] === 'message_enable') {
        // То необходимо отобразить список сообщений или сообщение
        $showMessage = true;
        break;
    }
}

// Формирование массива "Сообщения пользователя"
// Запрос к базе данных - поиск в таблице "messages" строки с адресатом $userId
$result = mysqli_query(
    $connection,
    "SELECT m.id, m.title, m.text, m.created_at, m.created_by, m.user_id_to, m.read, sections.name AS section_name, users.full_name AS user_name_from, users.email AS user_email_from FROM messages AS m
        LEFT JOIN sections ON m.user_id_to = '{$userProfile['id']}'
            LEFT JOIN users ON m.created_by = users.id WHERE m.section_id = sections.id"
);
// Считывание результата в массив до тех пор, пока он выдаётся
while ($arr = mysqli_fetch_assoc($result)) {
    if ($arr['read']) {
        // Добавление результата в многомерный массив "Прочитанные сообщения пользователя"
        $userMessagesRead[] = $arr;
        // Если это сообщение читают
        if (isset($_GET['message_id']) && $_GET['message_id'] === $arr['id']) {
            // Добавление результата в массив "Сообщение пользователя для просмотра"
            $userMessage = $arr;
        }
    } else {
        // Добавление результата в многомерный массив "Непрочитанные сообщения пользователя"
        $userMessagesNotRead[] = $arr;
        // Если это сообщение читают
        if (isset($_GET['message_id']) && $_GET['message_id'] === $arr['id']) {
            // Добавление результата в массив "Сообщение пользователя для просмотра"
            $userMessage = $arr;
            // Сообщение становится прочитанным, необходима соответствующая запись в базу
            mysqli_query (
                $connection,
                "UPDATE messages SET `read` = '1' WHERE id = {$arr['id']}"
            );
        }
    }
}

// Закрыть соединение с сервером MySQL
disconnectDb($connection);