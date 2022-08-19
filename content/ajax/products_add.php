<?php
// Соединение c сервером MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
// Директория, куда будет загружаться файл изображения
$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';

// Если не выбрано ни одного файла
if ($_FILES['product-photo']['error'] === UPLOAD_ERR_NO_FILE) {
    // Вывести сообщение и прекратить выполнение текущего скрипта
    exit(json_encode(false));
}
// Если заполнены поля формы
// "Название товара",
// "Цена товара",
// "Раздел товара"
if (isset($_POST['product-name']) &&
    isset($_POST['product-price']) &&
    isset($_POST['category']))
{
    // Начальное значение результата запроса базы данных - без ошибок
    $result = true;
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Экранирование всех данных для записи в таблицу 'products'
    $name = mysqli_real_escape_string($connection, $_POST['product-name']);
    $img_name = mysqli_real_escape_string($connection, $_FILES['product-photo']['name']);
    $price = mysqli_real_escape_string($connection, $_POST['product-price']);
    // TODO - в БД сделать '1' или 'null'
    $new = isset($_POST['new']) // Если чекбокс "Новинка" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    $sale = isset($_POST['sale']) // Если чекбокс "Распродажа" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    // Если это изменение старого товара
    if (isset($_POST['product-id'])) {
        // Новое название изображения, которое будет присвоено продукту (состоит из ID +
        // название загружаемого файла) - теперь уникальное
        $newNamePhoto = $_POST['product-id'] . '_' . $_FILES['product-photo']['name'];
        // Загрузка файла в папку, если нет никаких ошибок
        // TODO - проверить возвращаемое значение
        move_uploaded_file($_FILES['product-photo']['tmp_name'], $uploadPath . $newNamePhoto);
        // Обновление данных
        mysqli_query (
            $connection,
            "UPDATE products SET
            `name` = '$name',
            `img_name` = '$newNamePhoto',
            `price` = '$price',
            `new` = '$new',
            `sale` = '$sale'
            WHERE `id` = {$_POST['product-id']}"
        );
    }
    // Если это добавление нового товара
    else {
        // Добавление товара в таблицу 'products'
        $result = mysqli_query (
            $connection,
            "INSERT INTO products (`name`, `img_name`, `price`, `new`, `sale`)
        VALUES ('$name', '$img_name', '$price', '$new', '$sale')"
        );
        // Запрос к базе данных - поиск в таблице "products" ID последней записи таблицы
        //(т.е. ID товара, который только что был добавлен в таблицу)
        $resultSelect = mysqli_query(
            $connection,
            "SELECT * FROM products ORDER BY products.id DESC LIMIT 1;"
        );
        // Преобразование результата запроса в ассоциативный массив "Продукт"
        $product = mysqli_fetch_assoc($resultSelect);
        // Новое название изображения, которое будет присвоено продукту (состоит из ID +
        // название загружаемого файла) - теперь уникальное
        $newNamePhoto = $product['id'] . '_' . $_FILES['product-photo']['name'];
        // Загрузка файла в папку, если нет никаких ошибок
        move_uploaded_file($_FILES['product-photo']['tmp_name'], $uploadPath . $newNamePhoto);
        // Обновление название файла изображения в таблице
        mysqli_query (
            $connection,
            "UPDATE products SET `img_name` = '$newNamePhoto' WHERE id = {$product['id']}"
        );
    }
    // Если это изменение товара, то сначала надо удалить данные по этому товару
    // из таблицы связей
    if (isset($_POST['product-id'])) {
        // Удаление строк товара из таблицы 'categories_products'
        $result = mysqli_query (
            $connection,
            "DELETE FROM categories_products WHERE product_id = {$_POST['product-id']}"
        );
    }
    // Добавление всех ID разделов нашего товара в базу данных
    foreach ($_POST['category'] as $value) {
        // Если до этого момента не было ошибок при работе с базой данных
        if ($result) {
            // Экранирование информации о каждом разделе отдельно
            $categoryId = mysqli_real_escape_string($connection, $value);
            $productId = $_POST['product-id'] ?? $product['id'];
            // Добавление ID раздела нашего продукта в базу данных
            $result = mysqli_query (
                $connection,
                "INSERT INTO categories_products (`product_id`, `category_id`)
                    VALUES ('$productId', '$categoryId')"
            );
        }
    }
    //var_dump($result);
    // Передача ответа браузеру в формате json
    echo json_encode($result);
    // Закрыть соединение с сервером MySQL
    disconnectDb($connection);
}
// Если обязательные поля не заполнены (не относится к полю "Изображение")
else {
    // Передача ответа браузеру в формате json
    echo json_encode(false);
}