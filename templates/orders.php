<main class="page-order">
    <h1 class="h h--1">Список заказов</h1>
    <ul class="page-order__list">
        <?php if (isset($orders)): ?>
            <?php foreach ($orders as $value): ?>
                <li class="order-item page-order__item">
                    <div class="order-item__wrapper">
                        <div class="order-item__group order-item__group--id">
                            <span class="order-item__title">Номер заказа</span>
                            <span class="order-item__info order-item__info--id"><?=$value['id']?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Сумма заказа</span>
                            <?=$value['price']?> руб.
                        </div>
                        <button class="order-item__toggle"></button>
                    </div>
                    <div class="order-item__wrapper">
                        <div class="order-item__group order-item__group--margin">
                            <span class="order-item__title">Заказчик</span>
                            <span class="order-item__info"><?=$value['created_by']?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Номер телефона</span>
                            <span class="order-item__info"><?=$value['phone']?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Способ доставки</span>
                            <span class="order-item__info"><?=$value['delivery'] === 'Самовывоз' ? 'Самовывоз' : 'Курьер'?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Способ оплаты</span>
                            <span class="order-item__info"><?=$value['payment'] == 1 ? 'Наличными' : 'Банковской картой'?></span>
                        </div>
                        <div class="order-item__group order-item__group--status">
                            <span class="order-item__title">Статус заказа</span>
                            <span class="order-item__info <?=$value['status'] == 1 ? 'order-item__info--yes' : 'order-item__info--no'?>"><?=$value['status'] == 1 ? 'Обработан' : 'Не обработан'?></span>
                            <button value = <?= $value['id']?> class="order-item__btn">Изменить</button>
                        </div>
                    </div>
                    <div class="order-item__wrapper">
                        <div class="order-item__group">
                            <span class="order-item__title">Адрес доставки</span>
                            <span class="order-item__info"><?=$value['delivery'] === 'Самовывоз' ? DELIVERY_ADDRESS : $value['delivery']?></span>
                        </div>
                    </div>
                    <div class="order-item__wrapper">
                        <div class="order-item__group">
                            <span class="order-item__title">Комментарий к заказу</span>
                            <span class="order-item__info"><?=$value['comment']?></span>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
            <ul class="shop__paginator paginator">
                <?php foreach ($pageButtons as $button => $value): ?>
                    <?php if (isset($value['show'])): ?>
                        <li>
                            <a class="<?=$value['class']?>"
                                <?php if ($button != 'active' && $button != 'firstSep' && $button != 'lastSep'): ?>
                                    href="<?=PATH_ORDERS_LIST . '?page=' . $value['num']?>"
                                <?php endif ?>>
                                <?=$value['text']?>
                            </a>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        <?php else: ?>
            <div>
                Список заказов пуст, не сделано ни одного заказа
            </div>
        <?php endif ?>
    </ul>
</main>