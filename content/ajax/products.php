<?php
// Модуль обработки полученного от браузера ID продукта, данные о котором
// необходимо удалить из базы данных
// Соединение c сервером MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
// Директория, где располагаются загруженные изображения
$imgPath = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';

// Если ID продукта получен
if (isset($_GET['idProduct'])){
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Экранирование данных
    //$idProduct = (int)$_GET['idProduct'];
    $idProduct = mysqli_real_escape_string($connection, $_GET['idProduct']);
    // Извлекаем название файла изображения удаляемого товара из базы данных
    $resultSelect = mysqli_query(
        $connection,
        "SELECT * FROM products WHERE id = $idProduct;"
    );
    // Преобразование результата запроса в ассоциативный массив "Продукт"
    $product = mysqli_fetch_assoc($resultSelect);
    // Удаление файла изображения из папки
    unlink($imgPath . $product['img_name']);
    // Удаление строки товара из таблицы 'products'
    $result = mysqli_query (
        $connection,
        "DELETE FROM products WHERE id = $idProduct"
    );
    // Передача ответа браузеру в формате json
    echo json_encode($result);
    // Закрыть соединение с сервером MySQL
    disconnectDb($connection);
}
// Если ID продукта не получен
else {
    // Передача ответа браузеру
    echo json_encode(false);
}
