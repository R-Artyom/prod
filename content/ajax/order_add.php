<?php
/**
 * Обработка AJAX запросов страницы "Оформление заказа"
 */
// База данных MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/db.php';
// Доставка товара
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/delivery.php';

// Признак - "Заполнены все обязательные поля "Личные данные" формы"
$isPersonalFull = !empty($_POST['surname'])
                    && !empty($_POST['name'])
                        && !empty($_POST['phone'])
                            && !empty($_POST['email']);
// Признак - "Заполнены все обязательные поля "Адрес доставки" формы"
$isAddressFull = !empty($_POST['city'])
                    && !empty($_POST['street'])
                        && !empty($_POST['home'])
                            && !empty($_POST['aprt']);
// Признак - заполнены все обязательные поля формы
$isAllFull = $_POST['delivery'] === 'dev-no' ? $isPersonalFull : $isPersonalFull && $isAddressFull;
if ($isAllFull) {
    // Начальное значение результата запроса базы данных - без ошибок
    $result = true;
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Извлекаем данные о товаре из базы
    $resultSelect = mysqli_query($connection,
        "SELECT * FROM products WHERE id = {$_POST['productId']};"
    );
    // Преобразование результата запроса в ассоциативный массив "Продукт"
    $product = mysqli_fetch_assoc($resultSelect);
    // Экранирование данных
    $created_by = mysqli_real_escape_string($connection, $_POST['surname'] . " " . $_POST['name'] . " " . $_POST['thirdName']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $product_id = mysqli_real_escape_string($connection, $_POST['productId']);
    $price = mysqli_real_escape_string($connection, (float)$product['price'] < DELIVERY_LIMIT ? (float)$product['price'] + DELIVERY_PRICE : (float)$product['price']);
    $delivery = $_POST['delivery'] === 'dev-no' // Если чекбокс "Самовывоз" отмечен
        ? mysqli_real_escape_string($connection, 'Самовывоз')
        : mysqli_real_escape_string($connection, "г. " . $_POST['city'] . ", ул. " . $_POST['street'] . ", д. " . $_POST['home'] . ", кв. " . $_POST['aprt']);
    $payment = $_POST['pay'] === 'cash' // Если чекбокс "Наличные" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    $status = mysqli_real_escape_string($connection, 0);
    $comment = mysqli_real_escape_string($connection, $_POST['comment']);
    // Запись данных в базу
    $result = mysqli_query ($connection,
        "INSERT INTO orders (`created_by`, `phone`, `email`, `product_id`, `price`, `delivery`, `payment`, `status`, `comment`)
            VALUES ('$created_by', '$phone', '$email', '$product_id', '$price', '$delivery', '$payment', '$status', '$comment')"
    );
    // Передача ответа браузеру в формате json
    echo json_encode($result);
    // Закрыть соединение с сервером MySQL
    disconnectDb($connection);
}
// Если обязательные поля не заполнены
else {
    // Передача ответа браузеру в формате json
    echo json_encode(false);
}
