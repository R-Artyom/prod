<!--<ul class="main-menu --><?//=$class?><!--">-->
    <?php foreach ($arraySort as $value): ?>
        <li>
            <a class="main-menu__item <?= isCurrentUrl($value['path']) ? 'active' : '' ?>" href="<?= $value['path']?>"><?= cutString($value['title']) ?></a>
        </li>
    <?php endforeach ?>
<!--    <li>-->
<!--        <a class="main-menu__item" href="/">Главная</a>-->
<!--    </li>-->
<!--    <li>-->
<!--        <a class="main-menu__item" href="#">Новинки</a>-->
<!--    </li>-->
<!--    <li>-->
<!--        <a class="main-menu__item active">Sale</a>-->
<!--    </li>-->
<!--    <li>-->
<!--        <a class="main-menu__item" href="/delivery.php">Доставка</a>-->
<!--    </li>-->
<!--</ul>-->
