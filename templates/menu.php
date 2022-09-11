<?php foreach ($menuNavigation as $value): ?>
    <li>
        <a class="main-menu__item <?= $urlActive === $value['path'] ? 'active' : '' ?>" href="<?= $value['path']?>"><?= $value['title'] ?></a>
    </li>
<?php endforeach ?>