<main class="page-add">
    <h1 class="h h--1"><?=$title?></h1>
    <div id="result">
        <!-- Вывод сообщения из ajax.php -->
    </div>
    <form id="formAddProduct" class="custom-form" action="<?=PATH_PRODUCTS_ADD?>" method="post">
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
                <input type="text" class="custom-form__input" name="product-name" id="product-name">
                <p class="custom-form__input-label">
                    Название товара
                </p>
            </label>
            <label for="product-price" class="custom-form__input-wrapper">
                <input type="text" class="custom-form__input" name="product-price" id="product-price">
                <p class="custom-form__input-label">
                    Цена товара
                </p>
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <input type="file" name="product-photo" id="product-photo" hidden="">
                    <label for="product-photo">Добавить фотографию</label>
                </li>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>
            <div class="page-add__select">
                <select name="category" class="custom-form__select" multiple="multiple">
                    <option hidden="">Название раздела</option>
                    <option value="1">Женщины</option>
                    <option value="2">Мужчины</option>
                    <option value="3">Дети</option>
                    <option value="4">Аксессуары</option>
                </select>
            </div>
            <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
            <label for="new" class="custom-form__checkbox-label">Новинка</label>
            <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button class="button" type="submit">Добавить товар</button>
    </form>
    <section id="popUpSuccess" class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
            <a class="page-products__button button" href="<?=PATH_PRODUCTS_LIST?>">Список товаров</a>
        </div>
    </section>
</main>