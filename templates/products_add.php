<main class="page-add">
    <h1 class="h h--1"><?=$title?></h1>
    <form id="formAddProduct" class="custom-form" action="<?=PATH_PRODUCTS_ADD?>" method="post">
        <?php if (isset($product)): ?>
            <input type="text" name="product-id" value="<?=$product['id']?>" hidden="hidden">
        <?php endif ?>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
                <input type="text" class="custom-form__input" name="product-name" id="product-name" required = "required" value = "<?=$product['name'] ?? ''?>">
                <p class="custom-form__input-label" <?=isset($product) ? 'hidden="hidden"' : ''?>>
                    Название товара
                </p>
            </label>
            <label for="product-price" class="custom-form__input-wrapper">
                <input type="text" class="custom-form__input" name="product-price" id="product-price" required = "required" value = "<?=$product['price'] ?? ''?>">
                <p class="custom-form__input-label" <?=isset($product) ? 'hidden="hidden"' : ''?>>
                    Цена товара
                </p>
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <div id="product-photo-old">
                <?php if (isset($product)): ?>
                    <img src="/img/products/<?=$product['img_name'] . '?t=' . $timeUploadImg?>"><br/><br/>
                <?php endif ?>
            </div>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <input type="file" name="product-photo" id="product-photo" hidden="">
                    <label for="product-photo"><?=isset($product) ? 'Изменить фотографию?' : 'Добавить фотографию'?></label>
                </li>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>
            <div class="page-add__select">
                <select name="category[]" class="custom-form__select" multiple="multiple" required = "required">
                    <option hidden="">Название раздела</option>
                    <option value="1" <?=$categories['1'] ?? ''?>>Женщины</option>
                    <option value="2" <?=$categories['2'] ?? ''?>>Мужчины </option>
                    <option value="3" <?=$categories['3'] ?? ''?>>Дети</option>
                    <option value="4" <?=$categories['4'] ?? ''?>>Аксессуары</option>
                </select>
            </div>
            <!--TODO-->
            <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?=isset($product['new']) && $product['new'] == 1 ? 'checked="checked"' : ''?>>
            <label for="new" class="custom-form__checkbox-label">Новинка</label>
            <!--TODO-->
            <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?=isset($product['sale']) && $product['sale'] == 1 ? 'checked="checked"' : ''?>>
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <div id="result">
            <!-- Вывод сообщения из ajax.php -->
        </div>
        <button class="button" type="submit"><?=isset($product) ? 'Сохранить изменения' : 'Добавить товар'?></button>
    </form>
    <section id="popUpSuccess" class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно <?=isset($product) ? 'изменён' : 'добавлен'?></h2>
            <a class="page-products__button button" href="<?=PATH_PRODUCTS_LIST?>">Список товаров</a>
        </div>
    </section>
</main>