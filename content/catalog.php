<?php
// Количество записей на одной странице
$pageLimit = 9;
// Время загрузки изображения товара на страницу. (Будет добавляться
// к адресу изображения в качестве GET-параметров для избежания
// загрузки кэшированного изображения. Если этого не делать, то будет
// отображаться старая фотография с тем же названием)
$timeUploadImg = time();

// Установить соединение с сервером MySQL
$connection = connectDb();
// Запрос количества записей в таблице 'products'
$resultSelect = mysqli_query(
    $connection,
    "SELECT COUNT(*) FROM products;"
);
//Запись результата в массив
$row = mysqli_fetch_row($resultSelect);
// Количество товаров в списке товаров
$productCount = $row[0];
// Общее количество страниц
$pageCount = ceil($productCount / $pageLimit);
// Номер активной (текущей) страницы (если не задан - то "1", если больше
// последней страницы - то приравнивается к последней странице)
$pageActive = $_GET['page'] ?? 1;
$pageActive = $pageActive < $pageCount ? $pageActive : $pageCount;
// Смещение (для запроса к БД)
$pageOffset = $pageLimit * ($pageActive - 1);
// Запрос к базе данных - поиск в таблице "products" всех элементов, при этом
// столбец 'category' заполняется всеми наименованиями разделов, в которые входит
// продукт, через запятую с пробелом
$resultSelect = mysqli_query($connection,
    "SELECT p.id, p.name, p.img_name, p.price, p.new, p.sale, GROUP_CONCAT(categories.name SEPARATOR ', ') as category FROM products AS p
        LEFT JOIN categories_products ON categories_products.product_id = p.id
                  LEFT JOIN categories ON categories_products.category_id = categories.id
                        GROUP BY p.id
                        LIMIT $pageLimit OFFSET $pageOffset"
);
// Если есть товары, удовлетворяющие запросу
if ($resultSelect) {
    // Считывание результата в массив до тех пор, пока он выдаётся
    while ($arr = mysqli_fetch_assoc($resultSelect)) {
        $products[] = $arr;
    }
    // Формирование массива "Кнопки страниц", необходимого для постраничной навигции
    $pageButtons = getPageButtons($pageActive, $pageCount);
    // Формирование фразы "Найдено х моделей"
    $msgProductCount = getPhraseCountModels($productCount);
}