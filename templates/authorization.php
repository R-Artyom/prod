<main class="page-authorization">
    <h1 class="h h--1"><?=$title?></h1>
    <form class="custom-form" action="<?=PATH_ACCOUNT_AUTHORIZATION?>" method="post">
        <?php if (isAuthorization()): ?>
            <span>Ваш e-mail: <b><?= $convertLogin ?></b><br/><br/></span>
            <span>Ваш статус: <b><?= $statusUser ?></b><br/><br/></span>
            <?php if (isset($flLogInSuccess) && $flLogInSuccess): ?>
                <span id="success"><?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/msg_auth_success.php'; ?><br/><br/></span>
            <?php endif ?>
            <input class="button" type="submit" name="log_out" value="Выйти">
        <?php elseif (isset($isShowErrorLogIn) && $isShowErrorLogIn): ?>
            <span id="error"><?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/msg_auth_error.php'; ?><br/><br/></span>
            <input type="email" name="login" class="custom-form__input" placeholder="Ваш e-mail" value="<?= htmlspecialchars($loginError) ?>" required="">
            <input type="password" name="password" class="custom-form__input" placeholder="Ваш пароль" value="<?= htmlspecialchars($passwordError) ?>" required="">
            <button class="button" type="submit">Войти в личный кабинет</button>
        <?php else: ?>
            <input type="email" name="login" class="custom-form__input" placeholder="Ваш e-mail" required="">
            <input type="password" name="password" class="custom-form__input" placeholder="Ваш пароль" required="">
            <button class="button" type="submit">Войти в личный кабинет</button>
        <?php endif ?>
    </form>
</main>