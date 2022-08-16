<?php
// Установить соединение с сервером MySQL
$connection = connectDb();
// Запрос к базе данных - поиск в таблице "products" всех элементов, при этом
// столбец 'category' заполняется всеми наименованиями разделов, в которые входит
// продукт, через запятую с пробелом
$resultSelect = mysqli_query($connection,
    "SELECT p.id, p.name, p.img_name, p.price, p.new, p.sale, GROUP_CONCAT(categories.name SEPARATOR ', ') as category FROM products AS p
        LEFT JOIN categories_products ON categories_products.product_id = p.id
                  LEFT JOIN categories ON categories_products.category_id = categories.id
                        GROUP BY p.id"
);
// Считывание результата в массив до тех пор, пока он выдаётся
while ($arr = mysqli_fetch_assoc($resultSelect)) {
    $products[] = $arr;
}
