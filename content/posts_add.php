<?php
/**
 * Страница с отображением формы отправки сообщений
 */

// Путь к шаблону страницы
$pathTemplate = '/templates/posts_add.php';

// Флаг - отобразить форму отправки сообщения
$showFormMessage = false;
// Установить соединение с сервером MySQL
$connection = connectDb();

// Отправка сообщения
// Если нажата кнопка "Оправить"
if (isset($_POST) && isset($_POST['send_button']))
{
    // То необходимо записать сообщение в базу данных, предварительно экранируя все данные
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $text = mysqli_real_escape_string($connection, $_POST['text']);
    $user_id_from = mysqli_real_escape_string($connection, $_POST['user_id_from']);
    $user_id_to = mysqli_real_escape_string($connection, $_POST['user_id_to']);
    $section_id = mysqli_real_escape_string($connection, $_POST['section_id']);
    $result = mysqli_query (
        $connection,
        "INSERT INTO messages (`title`, `text`, `created_by`, `user_id_to`, `section_id`)
            VALUES ('$title', '$text', '$user_id_from', '$user_id_to', '$section_id')"
    );
    // Флаг - Сообщение отправлено
    $isMessageSent = $result;
    // Если произошла ошибка при отправке сообщения
    if (!$isMessageSent)
    {
        // Копирование массива с данными о неотправленном сообщении
        foreach ($_POST as $key => $value) {
            $messageError[$key] = htmlspecialchars($value);
        }
    }
}

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
        // То необходимо отобразить форму отправки сообщения
        $showFormMessage = true;
        break;
    }
}

// Формирование массива "Пользователи, кому можно отправлять сообщения"
// Запрос к базе данных - поиск в таблице "users" пользователей из группы "message_enable"
$result = mysqli_query(
    $connection,
    "SELECT users.id, users.full_name, `groups`.name AS group_name FROM users
        LEFT JOIN group_user on users.id = group_user.user_id
            LEFT JOIN `groups` on group_user.group_id = `groups`.id WHERE `groups`.name = 'message_enable' AND group_user.user_id != '{$userProfile['id']}'"
);
// Добавление результата в многомерный массив "Пользователи"
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Формирование массива "Раздел сообщений"
// Запрос к базе данных - поиск в таблице "sections" названий разделов и их цвета
$result = mysqli_query(
    $connection,
    "SELECT sections.id, sections.name, colors.name AS color_name FROM sections
        LEFT JOIN colors ON colors.id = sections.color_id"
);
// Добавление результата в многомерный массив "Раздел сообщений"
$sections = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Закрыть соединение с сервером MySQL
disconnectDb($connection);