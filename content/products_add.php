<?php
// Изменение товара
// Если передан GET-параметр, а конкретно - ID изменяемого товара
if (isset($_GET['id'])) {
    // Преобразование полученного значения в целое число
    $idProduct = (int)$_GET['id'];
    // Если в строке адреса введён корректный номер ID
    if ($idProduct > 0) {
        // Начальное значение всех разделов товара - ни один не выбран
        $categories = ['1' => '', '2' => '', '3' => '', '4' => ''];
        // Установить соединение с сервером MySQL
        $connection = connectDb();
        // Извлекаем данные о товаре из базы
        $resultSelect = mysqli_query(
            $connection,
            "SELECT * FROM products WHERE id = $idProduct;"
        );
        // Преобразование результата запроса в ассоциативный массив "Продукт"
        $product = mysqli_fetch_assoc($resultSelect);
        // Извлекаем данные о всех разделах товара
        $resultSelect = mysqli_query(
            $connection,
            "SELECT * FROM categories_products WHERE product_id = $idProduct;"
        );
        // Считывание результата в массив до тех пор, пока он выдаётся
        while ($arr = mysqli_fetch_assoc($resultSelect)) {
            // Номер элемента = номер раздела
            $categories[$arr['category_id']] = 'selected="selected"';
        }
        // Закрыть соединение с сервером MySQL
        disconnectDb($connection);
    }
}