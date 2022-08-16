<main class="page-products">
    <h1 class="h h--1"><?=$title?></h1>
    <a class="page-products__button button" href="<?=PATH_PRODUCTS_ADD?>">Добавить товар</a>
    <?php if (isset($products)): ?>
        <div class="page-products__header">
            <span class="page-products__header-field">Название товара</span>
            <span class="page-products__header-field">ID</span>
            <span class="page-products__header-field">Цена</span>
            <span class="page-products__header-field">Категория</span>
            <span class="page-products__header-field">Новинка</span>
        </div>
        <?php foreach ($products as $value): ?>
            <ul class="page-products__list">
                <li class="product-item page-products__item">
                    <b class="product-item__name"><?= $value['name']?></b>
                    <span class="product-item__field"><?= $value['id']?></span>
                    <span class="product-item__field"><?= $value['price']?> руб.</span>
                    <span class="product-item__field"><?= $value['category']?></span>
                    <span class="product-item__field"><?= $value['new'] ? 'Да' : ''?></span>
                    <a href="add.php" class="product-item__edit" aria-label="Редактировать"></a>
                    <button class="product-item__delete"></button>
                </li>
            </ul>
        <?php endforeach ?>
    <?php else: ?>
        <div>
            Для просмотра списка товаров необходимо добавить хотя бы один товар
        </div>
    <?php endif ?>
</main>