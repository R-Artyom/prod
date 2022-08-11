<?php
// Передача ответа браузеру в формате json
//echo json_encode('Сервер ответил');
// Соединение c сервером MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
// Если массив $_POST непустой (отличен от null)
if (isset($_POST))
{
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Экранирование всех данных для записи в БД
    $name = mysqli_real_escape_string($connection, $_POST['product-name']);
    $category_id = mysqli_real_escape_string($connection, $_POST['category']);
    $img_name = mysqli_real_escape_string($connection, 'img');
    $price = mysqli_real_escape_string($connection, $_POST['product-price']);
    $new = isset($_POST['new']) // Если чекбокс "Новинка" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    $sale = isset($_POST['sale']) // Если чекбокс "Распродажа" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    // Добавление товара в базу данных
    $result = mysqli_query (
        $connection,
        "INSERT INTO products (`name`, `category_id`, `img_name`, `price`, `new`, `sale`)
            VALUES ('$name', '$category_id', '$img_name', '$price', '$new', '$sale')"
    );
    //var_dump($result);
    // Передача ответа браузеру в формате json
    echo json_encode($result);
    // Закрыть соединение с сервером MySQL
    disconnectDb($connection);
}

