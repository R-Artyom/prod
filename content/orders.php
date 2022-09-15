<?php
// Количество записей на одной странице
$pageLimit = 10;
// Установить соединение с сервером MySQL
$connection = connectDb();
// Запрос количества записей в таблице 'products'
$resultSelect = mysqli_query(
    $connection,
    "SELECT COUNT(*) FROM orders;"
);
//Запись результата в массив
$row = mysqli_fetch_row($resultSelect);
// Количество заказов в списке заказов
$orderCount = $row[0];
// Общее количество страниц
$pageCount = ceil($orderCount / $pageLimit);
// Номер активной (текущей) страницы (если не задан - то "1", если больше
// последней страницы - то приравнивается к последней странице)
$pageActive = $_GET['page'] ?? 1;
$pageActive = $pageActive < $pageCount ? $pageActive : $pageCount;
// Смещение (для запроса к БД)
$pageOffset = $pageLimit * ($pageActive - 1);
// Запрос к базе данных - поиск в таблице "orders" всех элементов (по убыванию
// даты создания, при этом сначала выводятся все необработанные заказы,
// а затем обработанные)
$resultSelect = mysqli_query($connection,
    "SELECT * FROM orders
        ORDER BY `status` ASC, created_at DESC
            LIMIT $pageLimit OFFSET $pageOffset"
);
// Считывание результата в массив до тех пор, пока он выдаётся
if ($resultSelect) {
    while ($arr = mysqli_fetch_assoc($resultSelect)) {
        $orders[] = $arr;
    }
    // Формирование массива "Кнопки страниц", необходимого для постраничной навигции
    $pageButtons = getPageButtons($pageActive, $pageCount);
}