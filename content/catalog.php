<?php
// Количество записей на одной странице
$pageLimit = 9;
// Время загрузки изображения товара на страницу. (Будет добавляться
// к адресу изображения в качестве GET-параметров для избежания
// загрузки кэшированного изображения. Если этого не делать, то будет
// отображаться старая фотография с тем же названием)
$timeUploadImg = time();

/**
 * Поиск активной (текущей) страницы
 */
// Если это страница "Распродажа"
if ((strpos($_SERVER["REQUEST_URI"], PATH_CATALOG_SALE) === 0)) {
    $pathActive = PATH_CATALOG_SALE;
// Если это страница "Новинки"
} else if ((strpos($_SERVER["REQUEST_URI"], PATH_CATALOG_NEW) === 0)) {
    $pathActive = PATH_CATALOG_NEW;
// Если это страница "Главная"
} else {
    $pathActive = PATH_CATALOG;
}
// Массив "Категории товаров"
$category = [
    // Все
    'all' => [
        'name' => 'Все', // Название категории
        'nameDb' => '\'Женщины\' OR \'Мужчины\' OR \'Дети\' OR \'Аксессуары\'', // Название категории дл БД
        'path' => $pathActive . PATH_ALL, // Ссылка на страницу категории
        'class' => 'filter__list-item', // Класс CSS категории по умолчанию
    ],
    // Женщины
    'woman' => [
        'name' => 'Женщины',
        'nameDb' => '\'Женщины\'',
        'path' => $pathActive . PATH_WOMAN,
        'class' => 'filter__list-item',
    ],
    // Мужчины
    'man' => [
        'name' => 'Мужчины',
        'nameDb' => '\'Мужчины\'',
        'path' => $pathActive . PATH_MAN,
        'class' => 'filter__list-item',
    ],
    // Дети
    'children' => [
        'name' => 'Дети',
        'nameDb' => '\'Дети\'',
        'path' => $pathActive . PATH_CHILDREN,
        'class' => 'filter__list-item',
    ],
    // Аксессуары
    'accessories' => [
        'name' => 'Аксессуары',
        'nameDb' => '\'Аксессуары\'',
        'path' => $pathActive . PATH_ACCESSORIES,
        'class' => 'filter__list-item',
    ],
];
/**
 * Поиск активной (текущей) категории
 */
if (isCurrentUrl(PATH_MAIN) || isCurrentUrl($pathActive) || isCurrentUrl($pathActive . PATH_ALL)) {
    $categoryActive = 'all';
} else if (isCurrentUrl($pathActive . PATH_WOMAN)) {
    $categoryActive = 'woman';
} else if (isCurrentUrl($pathActive . PATH_MAN)) {
    $categoryActive = 'man';
} else if (isCurrentUrl($pathActive . PATH_CHILDREN)) {
    $categoryActive = 'children';
} else if (isCurrentUrl($pathActive . PATH_ACCESSORIES)) {
    $categoryActive = 'accessories';
}
// Для текущей категории меняется класс на активный
$category[$categoryActive]['class'] = 'filter__list-item active';
/**
 * Поиск количества товаров в соответствии с категорией
 */
// Установить соединение с сервером MySQL
$connection = connectDb();
// Для категории "Все"
if ($categoryActive === 'all') {
    // Запрос количества записей
    $resultSelect = mysqli_query($connection,
        "SELECT COUNT(*) FROM products;"
    );
// Для категорий 'Женщины', 'Мужчины', 'Дети', 'Аксессуары'
} else {
    // Запрос количества записей
    $resultSelect = mysqli_query($connection,
        "SELECT COUNT(*) FROM products
            LEFT JOIN categories_products ON categories_products.product_id = products.id
                LEFT JOIN categories ON categories_products.category_id = categories.id
                    WHERE categories.name IN ({$category[$categoryActive]['nameDb']});"
    );
}
// Запись результата в массив
$row = mysqli_fetch_row($resultSelect);
// Количество товаров в списке товаров
$productCount = $row[0];
/**
 * Поиск минимальной цены
 */
// Запрос количества записей в таблице 'products'
$resultSelect = mysqli_query($connection,
    "SELECT MIN(price) as min FROM products
        LEFT JOIN categories_products ON categories_products.product_id = products.id
            LEFT JOIN categories ON categories_products.category_id = categories.id
                WHERE categories.name IN ({$category[$categoryActive]['nameDb']});"
);
// Если есть товары, удовлетворяющие запросу
if ($resultSelect) {
    $row = mysqli_fetch_assoc($resultSelect);
    $sliderMin = (float)$row['min'];
}
/**
 * Поиск максимальной цены
 */
$resultSelect = mysqli_query($connection,
    "SELECT MAX(price) as max FROM products
        LEFT JOIN categories_products ON categories_products.product_id = products.id
            LEFT JOIN categories ON categories_products.category_id = categories.id
                WHERE categories.name IN ({$category[$categoryActive]['nameDb']});"
);
// Если есть товары, удовлетворяющие запросу
if ($resultSelect) {
    $row = mysqli_fetch_assoc($resultSelect);
    $sliderMax = (float)$row['max'];
}
/**
 * Поиск товаров, удовлетворяющих всем критериям
 */
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
                WHERE categories.name IN ({$category[$categoryActive]['nameDb']})        
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