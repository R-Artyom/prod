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
 * Поиск минимальной цены
 */
$resultSelect = mysqli_query($connection,
    "SELECT MIN(price) as min FROM products
        LEFT JOIN categories_products ON categories_products.product_id = products.id
            LEFT JOIN categories ON categories_products.category_id = categories.id
                WHERE categories.name IN ({$category[$categoryActive]['nameDb']});"
);
// Если есть товары, удовлетворяющие запросу
if ($resultSelect) {
    $row = mysqli_fetch_assoc($resultSelect);
    // Округление в меньшую сторону
    $sliderMin = floor((float)$row['min']);
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
    // Округление в большую сторону
    $sliderMax = ceil((float)$row['max']);
}
/**
 *  "Фильтры" - параметры get, добавляемые к адресу
 */
$filter = [
    // Сортировка (по цене (price), названию (name))
    'sort' => empty($_GET['sort']) ? null : $_GET['sort'],
    // Порядок (по возрастанию (ASC), убыванию (DESC))
    'order' => empty($_GET['order']) ? null : $_GET['order'],
    // Минимальная цена
    'sliderMin' => $_GET['sliderMin'] ?? null,
    // Максимальная цена
    'sliderMax' => $_GET['sliderMax'] ?? null,
    // Новинки
    'new' => isset($_GET['new']) || ($pathActive === PATH_CATALOG_NEW) ? 'new' : null,
    // Распродажа
    'sale' => isset($_GET['sale']) || ($pathActive === PATH_CATALOG_SALE) ? 'sale' : null,
];
// Массив с фильтрами для sql запросов
$filterDb = [
    // Сортировка (по цене (price), названию (name))
    'sort' => $filter['sort'] ?? 'name',
    // Порядок (по возрастанию (ASC), убыванию (DESC))
    'order' => $filter['order'] ?? 'ASC',
    // Минимальная цена
    'sliderMin' => $filter['sliderMin'] ?? $sliderMin,
    // Максимальная цена
    'sliderMax' => $filter['sliderMax'] ?? $sliderMax,
    // Новинки
    'new' => isset($filter['new']) ? 1 : 0,
    // Распродажа
    'sale' => isset($filter['sale']) ? 1 : 0,
];
// Формирование URL-кодированной строки
$query = http_build_query($filter);
// Формирование символа, необходимого при добавлении get-параметра "номер страницы"
if (strpos($_SERVER["REQUEST_URI"], '?') === false) {
    $joinGet = '?';
} else {
    $joinGet = '&';
}
/**
 * Поиск количества товаров в соответствии с категорией и фильтрами
 */
// Для категории "Все"
if ($categoryActive === 'all') {
    // Запрос количества записей
    $resultSelect = mysqli_query($connection,
        "SELECT COUNT(*) FROM products
                    WHERE products.new >= '{$filterDb['new']}'
                            AND products.sale >= '{$filterDb['sale']}'
                                AND products.price BETWEEN '{$filterDb['sliderMin']}' and '{$filterDb['sliderMax']}';"
    );
// Для категорий 'Женщины', 'Мужчины', 'Дети', 'Аксессуары'
} else {
    // Запрос количества записей
    $resultSelect = mysqli_query($connection,
        "SELECT COUNT(*) FROM products
            LEFT JOIN categories_products ON categories_products.product_id = products.id
                LEFT JOIN categories ON categories_products.category_id = categories.id
                    WHERE categories.name IN ({$category[$categoryActive]['nameDb']})
                        AND products.new >= '{$filterDb['new']}'
                            AND products.sale >= '{$filterDb['sale']}'
                                AND products.price BETWEEN '{$filterDb['sliderMin']}' and '{$filterDb['sliderMax']}';"
    );
}
// Запись результата в массив
$row = mysqli_fetch_row($resultSelect);
// Количество товаров в списке товаров
$productCount = $row[0];
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
                AND p.new >= '{$filterDb['new']}'
                AND p.sale >= '{$filterDb['sale']}'
                AND p.price BETWEEN '{$filterDb['sliderMin']}' and '{$filterDb['sliderMax']}'
                    GROUP BY p.id, p.{$filterDb['sort']}
                        ORDER BY p.{$filterDb['sort']} {$filterDb['order']}
                            LIMIT $pageLimit OFFSET $pageOffset;"
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