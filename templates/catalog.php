<main class="shop-page">
    <header class="intro">
        <div class="intro__wrapper">
            <h1 class=" intro__title">COATS</h1>
            <p class="intro__info">Collection 2022</p>
        </div>
    </header>
    <section class="shop container">
        <section class="shop__filter filter">
            <form method="get">
                <?php if (isset($filter['sort'])):?>
                    <input id="sort" type="text" name="sort" value="<?=$filter['sort']?>" hidden="hidden">
                <?php endif ?>
                <?php if (isset($filter['order'])):?>
                    <input id="order" type="text" name="order" value="<?=$filter['order']?>" hidden="hidden">
                <?php endif ?>
                <div class="filter__wrapper">
                    <b class="filter__title">Категории</b>
                    <ul class="filter__list">
                        <?php foreach ($category as $key => $value):?>
                            <li>
                                <a class="<?=$value['class']?>" href="<?=$value['path']?>"><?=$value['name']?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <?php if ($sliderMin != 0 && $sliderMax != 0):?>
                    <div class="filter__wrapper">
                        <b class="filter__title">Фильтры</b>
                        <div class="filter__range range">
                            <span class="range__info">Цена</span>
                            <div class="range__line" aria-label="Range Line"></div>
                            <div class="range__res">
                                <input id="sliderMin" type="text" name="sliderMin" value = "<?=$sliderMin?>" hidden="hidden">
                                <span class="range__res-item min-price"><?=$filter['sliderMin'] ?? $sliderMin?> руб.</span>
                                <input id="sliderMax" type="text" name="sliderMax" value = "<?=$sliderMax?>" hidden="hidden">
                                <span class="range__res-item max-price"><?=$filter['sliderMax'] ?? $sliderMax?> руб.</span>
                            </div>
                        </div>
                    </div>
                    <fieldset class="custom-form__group">
                        <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?=isset($filter['new']) ? 'checked="checked"' : ''?> <?=($pathActive === PATH_CATALOG_NEW) ? 'disabled="disabled"' : ''?>">
                        <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
                        <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?=isset($filter['sale']) ? 'checked="checked"' : ''?> <?=($pathActive === PATH_CATALOG_SALE) ? 'disabled="disabled"' : ''?>>
                        <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
                    </fieldset>
                    <button class="button" type="submit" style="width: 100%">Применить</button>
                <?php endif ?>
            </form>

        </section>

        <div class="shop__wrapper">
            <?php if (isset($products)):?>
                <form method="get" id="formSort">
                    <?php if (isset($filter['sliderMin'])):?>
                        <input type="text" name="sliderMin" value="<?=$filter['sliderMin']?>" hidden="hidden">
                    <?php endif ?>
                    <?php if (isset($filter['sliderMax'])):?>
                        <input type="text" name="sliderMax" value="<?=$filter['sliderMax']?>" hidden="hidden">
                    <?php endif ?>
                    <?php if (isset($filter['new'])):?>
                        <input type="text" name="new" value="<?=$filter['new']?>" hidden="hidden">
                    <?php endif ?>
                    <?php if (isset($filter['sale'])):?>
                        <input type="text" name="sale" value="<?=$filter['sale']?>" hidden="hidden">
                    <?php endif ?>
                    <section class="shop__sorting">
                        <div class="shop__sorting-item custom-form__select-wrapper">
                            <select class="custom-form__select" name="sort" onchange="document.getElementById('formSort').submit()">
                                <option value="" hidden="">Сортировка</option>
                                <option value="price" <?=$filter['sort'] === 'price'? 'selected="selected"' : ''?>>По цене</option>
                                <option value="name" <?=$filter['sort'] === 'name'? 'selected="selected"' : ''?>>По названию</option>
                            </select>
                        </div>
                        <div class="shop__sorting-item custom-form__select-wrapper">
                            <select class="custom-form__select" name="order" onchange="document.getElementById('formSort').submit()">
                                <option value="" hidden="">Порядок</option>
                                <option value="asc" <?=$filter['order'] === 'asc'? 'selected="selected"' : ''?>>По возрастанию</option>
                                <option value="desc" <?=$filter['order'] === 'desc'? 'selected="selected"' : ''?>>По убыванию</option>
                            </select>
                        </div>
                        <p class="shop__sorting-res"><span class="res-sort"><?=$msgProductCount?></span></p>
                    </section>
                </form>
                <section class="shop__list">
                    <?php foreach ($products as $value):?>
                        <article id = "<?=(int)$value['id']?>" class="shop__item product" tabindex="0">
                            <div class="product__image">
                                <img src="/img/products/<?=$value['img_name'] . '?t=' . $timeUploadImg?>" alt="<?=$value['name']?>">
                            </div>
                            <p class="product__name"><?=$value['name']?></p>
                            <span class="product__price"><?=(float)$value['price']?> руб.</span>
                            <span class="product__price_delivery" hidden="hidden"><?=(float)$value['price'] < PRICE_LIMIT ? (float)$value['price'] + PRICE_DELIVERY : (float)$value['price']?></span>
                        </article>
                    <?php endforeach ?>
                </section>
                <ul class="shop__paginator paginator">
                    <?php foreach ($pageButtons as $button => $value): ?>
                        <?php if (isset($value['show'])): ?>
                            <li>
                                <a class="<?=$value['class']?>"
                                    <?php if ($button != 'active' && $button != 'firstSep' && $button != 'lastSep'): ?>
                                        href="<?=$_SERVER["REQUEST_URI"] . $joinGet . 'page=' . $value['num']?>"
                                    <?php endif ?>>
                                    <?=$value['text']?>
                                </a>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            <?php else: ?>
                <div>
                    Извините, в данной категории отсутствуют товары <?=($sliderMin != 0 && $sliderMax != 0) ? 'с указанными фильтрами' : ''?>
                </div>
            <?php endif ?>
        </div>
    </section>
    <section class="shop-page__order" hidden="">
        <div class="shop-page__wrapper">
            <h2 class="h h--1">Оформление заказа</h2>
            <form method="post" class="custom-form js-order">
                <input id="productId" type="text" name="productId" value="" hidden="hidden">
                <fieldset class="custom-form__group">
                    <legend class="custom-form__title">Укажите свои личные данные</legend>
                    <p class="custom-form__info">
                        <span class="req">*</span> поля обязательные для заполнения
                    </p>
                    <div class="custom-form__column">
                        <label class="custom-form__input-wrapper" for="surname">
                            <input id="surname" class="custom-form__input" type="text" name="surname" required="">
                            <p class="custom-form__input-label">Фамилия <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="name">
                            <input id="name" class="custom-form__input" type="text" name="name" required="">
                            <p class="custom-form__input-label">Имя <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="thirdName">
                            <input id="thirdName" class="custom-form__input" type="text" name="thirdName">
                            <p class="custom-form__input-label">Отчество</p>
                        </label>
                        <label class="custom-form__input-wrapper" for="phone">
                            <input id="phone" class="custom-form__input" type="tel" name="phone" required="">
                            <p class="custom-form__input-label">Телефон <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="email">
                            <input id="email" class="custom-form__input" type="email" name="email" required="">
                            <p class="custom-form__input-label">Почта <span class="req">*</span></p>
                        </label>
                    </div>
                </fieldset>
                <fieldset class="custom-form__group js-radio">
                    <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
                    <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="dev-no" checked="">
                    <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
                    <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="dev-yes">
                    <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
                </fieldset>
                <div class="shop-page__delivery shop-page__delivery--no">
                    <table class="custom-table">
                        <caption class="custom-table__title">Пункт самовывоза</caption>
                        <tr>
                            <td class="custom-table__head">Адрес:</td>
                            <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Время работы:</td>
                            <td>пн-вс 09:00-22:00</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Оплата:</td>
                            <td>Наличными или банковской картой</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Срок доставки: </td>
                            <td class="date">13 декабря—15 декабря</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Стоимость заказа:</td>
                            <td id="price">3000</td>
                        </tr>
                    </table>
                </div>
                <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
                    <fieldset class="custom-form__group">
                        <legend class="custom-form__title">Адрес</legend>
                        <p class="custom-form__info">
                            <span class="req">*</span> поля обязательные для заполнения
                        </p>
                        <div class="custom-form__row">
                            <label class="custom-form__input-wrapper" for="city">
                                <input id="city" class="custom-form__input" type="text" name="city">
                                <p class="custom-form__input-label">Город <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="street">
                                <input id="street" class="custom-form__input" type="text" name="street">
                                <p class="custom-form__input-label">Улица <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="home">
                                <input id="home" class="custom-form__input custom-form__input--small" type="text" name="home">
                                <p class="custom-form__input-label">Дом <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="aprt">
                                <input id="aprt" class="custom-form__input custom-form__input--small" type="text" name="aprt">
                                <p class="custom-form__input-label">Квартира <span class="req">*</span></p>
                            </label>
                        </div>
                        <table class="custom-table">
                            <tr>
                                <td class="custom-table__head">Стоимость заказа с доставкой:</td>
                                <td id="priceDelivery">3000</td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <fieldset class="custom-form__group shop-page__pay">
                    <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
                    <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
                    <label for="cash" class="custom-form__radio-label">Наличные</label>
                    <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
                    <label for="card" class="custom-form__radio-label">Банковской картой</label>
                </fieldset>
                <fieldset class="custom-form__group shop-page__comment">
                    <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
                    <textarea class="custom-form__textarea" name="comment"></textarea>
                </fieldset>
                <button class="button" type="submit">Отправить заказ</button>
            </form>
            <div id="result">
                <!-- Вывод сообщения из ajax.php -->
            </div>
        </div>
    </section>
    <section class="shop-page__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
            <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
            <a class="page-products__button button" href="<?=$_SERVER["REQUEST_URI"]?>">Продолжить покупки</a>
        </div>
    </section>
</main>
