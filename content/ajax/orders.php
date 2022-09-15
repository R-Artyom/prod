<?php
/**
 * Модуль обработки полученного от браузера ID заказа, статус которого необходимо
 * изменить в базе
 */
// База данных MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/db.php';
// Если ID заказа получен
if (isset($_GET['orderId'])) {
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Экранирование данных
    //$orderId = (int)$_GET['orderId'];
    $orderId = mysqli_real_escape_string($connection, $_GET['orderId']);
    $orderStatus = mysqli_real_escape_string($connection, $_GET['orderStatus'] === 'Обработан' ? 0 : 1);
    // Обновление статуса заказа на противоположный
    $result = mysqli_query(
        $connection,
        "UPDATE orders SET `status` = '$orderStatus' WHERE id = $orderId"
    );
    // Передача ответа браузеру в формате json
    echo json_encode($result);
    // Закрыть соединение с сервером MySQL
    disconnectDb($connection);
// Если ID продукта не получен
} else {
    // Передача ответа браузеру
    echo json_encode(false);
}