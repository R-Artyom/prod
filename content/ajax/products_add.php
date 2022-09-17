<?php
/**
 * Обработка AJAX запросов страницы "Добавление/Изменение товара"
 */
// Данные о загружаемом файле
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/file.php';
// Соединение c сервером MySQL
require $_SERVER['DOCUMENT_ROOT'] . '/include/data/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/functions/db.php';
// Директория, куда будет загружаться файл изображения
$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';
// TODO проверка авторизации

// Если не выбрано ни одного файла и
if ($_FILES['product-photo']['error'] === UPLOAD_ERR_NO_FILE) {
    // Если это не страница "Изменение товара"
    if (!isset($_POST['product-id'])) {
        // Вывести сообщение и прекратить выполнение текущего скрипта
        exit(json_encode("Внимание!!! Необходимо добавить фотографию товара<br/><br/>"));
    }
// Если выбран файл
} else {
    // Если причина ошибки - слишком большой размер файла
    if ($_FILES['product-photo']['error'] === UPLOAD_ERR_FORM_SIZE) {
        // Вывести сообщение и прекратить выполнение текущего скрипта
        exit(json_encode("Внимание!!! Файл \"{$_FILES['product-photo']['name']}\" не загружен!!! Cлишком большой размер.<br/><br/>"));
    }
    // Определение типа файла в случае отсутствия ошибок при загрузке файла во временную директорию
    $mime_type = mime_content_type($_FILES['product-photo']['tmp_name']);
    // Если тип файла не найден в списке разрешенных
    if (!in_array ($mime_type, ALLOWED_IMG_TYPE, true)) {
        // Вывести сообщение и прекратить выполнение текущего скрипта
        exit(json_encode("Внимание!!! Файл \"{$_FILES['product-photo']['name']}\" не загружен!!! Тип файла не поддерживается.<br/><br/>"));
    }
}
// Если заполнены поля формы
// "Название товара",
// "Цена товара",
// "Раздел товара"
if (isset($_POST['product-name']) &&
    isset($_POST['product-price']) &&
    isset($_POST['category']))
{
    // Признак страницы "Изменение товара"
    $isChangeProduct = false;
    // Признак страницы "Добавление товара"
    $isAddProduct = false;
    // Признак того, что изображение продукта не надо менять (остаётся прежним)
    $flImageNotChange = false;
    // Формирование всех трёх признаков
    if (isset($_POST['product-id'])) {
        // ID изменяемого товара
        $productId = $_POST['product-id'];
        $isChangeProduct = true;
        if ($_FILES['product-photo']['error'] === UPLOAD_ERR_NO_FILE) {
            $flImageNotChange = true;
        }
    }
    else {
        $isAddProduct = true;
    }
    // Начальное значение результата запроса базы данных - без ошибок
    $result = true;
    // Установить соединение с сервером MySQL
    $connection = connectDb();
    // Экранирование всех данных для записи в таблицу 'products'
    $name = mysqli_real_escape_string($connection, $_POST['product-name']);
    $img_name = $img_name ?? '';
    $price = mysqli_real_escape_string($connection, $_POST['product-price']);
    $new = isset($_POST['new']) // Если чекбокс "Новинка" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    $sale = isset($_POST['sale']) // Если чекбокс "Распродажа" отмечен, то 1, иначе 0
        ? mysqli_real_escape_string($connection, 1)
        : mysqli_real_escape_string($connection, 0);
    // Если находимся на странице "Добавление товара"
    if ($isAddProduct) {
        // Добавление товара в таблицу 'products'
        $result = mysqli_query (
            $connection,
            "INSERT INTO products (`name`, `img_name`, `price`, `new`, `sale`)
            VALUES ('$name', '$img_name', '$price', '$new', '$sale')"
        );
        // Запрос к базе данных - поиск в таблице "products" ID последней записи
        // таблицы (т.е. ID товара, который только что был добавлен в таблицу)
        $resultSelect = mysqli_query(
            $connection,
            "SELECT * FROM products ORDER BY products.id DESC LIMIT 1;"
        );
        // Преобразование результата запроса в ассоциативный массив "Продукт"
        $product = mysqli_fetch_assoc($resultSelect);
        // ID добавляемого товара
        $productId = $product['id'];
    }
    // Если пользователь хочет добавить новое изображение на странице "Добавление
    // товара" или на странице "Изменение товара"
    if ($isAddProduct || !$flImageNotChange) {
        // Определение номера позиции знака "точка" в названии файла
        while (true) {
            // Начальное смещение при поиске
            static $offset = 0;
            // Поиск первой точки в названии файла, начиная с $offset
            $positionPointTmp  = mb_strpos($_FILES['product-photo']['name'], '.', $offset);
            // Если ни одной точки больше не найдено
            if ($positionPointTmp === false) {
                break;
            } else {
                $positionPoint = $positionPointTmp;
                // Менем смещение, для поиска следующей точки в названии
                $offset = $positionPoint + 1;
            }
        }
        // Определение расширение файла, зная позицию знака "точка"
        $filenameExtension = mb_substr($_FILES['product-photo']['name'], $positionPoint);
        // Новое уникальное название изображения, которое будет присвоено продукту
        // (состоит из ID товара + расширение загружаемого файла)
        $newNamePhoto = $productId . $filenameExtension;
        // Загрузка файла в папку, если нет никаких ошибок
        move_uploaded_file($_FILES['product-photo']['tmp_name'], $uploadPath . $newNamePhoto);
        // Обновление название файла изображения в таблице
        mysqli_query (
            $connection,
            "UPDATE products SET `img_name` = '$newNamePhoto' WHERE id = $productId"
        );
    }
    // Если находимся на странице "Изменение товара"
    if ($isChangeProduct) {
        // Обновление данных
        mysqli_query (
            $connection,
            "UPDATE products SET
                `name` = '$name',
                `price` = '$price',
                `new` = '$new',
                `sale` = '$sale'
                WHERE `id` = $productId"
        );
        // Чтобы не было проблем надо удалить данные по этому товару из таблицы связей
        // (всех строк товара из таблицы 'categories_products')
        $result = mysqli_query (
            $connection,
            "DELETE FROM categories_products WHERE product_id = $productId"
        );
    }
    // Добавление всех ID разделов нашего товара в базу данных
    foreach ($_POST['category'] as $value) {
        // Если до этого момента не было ошибок при работе с базой данных
        if ($result) {
            // Экранирование информации о каждом разделе отдельно
            $categoryId = mysqli_real_escape_string($connection, $value);
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