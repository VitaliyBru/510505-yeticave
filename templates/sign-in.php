
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach($categories as $category):?>
            <li class="nav__item">
                <a href="index.php?id=<?=$category['id']; ?>"><?=$category['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form container<?= $sign['errors'] ? ' form--invalid' : ''; ?>" action="sign-in.php" method="post"
      enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item<?= ($sign['errors'] && !$sign['email']) ? ' form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="sign[email]" placeholder="Введите e-mail" value="<?=htmlspecialchars($sign[0]['email']); ?>" required>
        <span class="form__error"></span>
    </div>
    <div class="form__item<?= ($sign['errors'] && !$sign['password']) ? ' form__item--invalid' : ''; ?>"><!-- form__item--invalid -->
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="sign[password]" placeholder="Введите пароль" value="<?=htmlspecialchars($sign[0]['password']); ?>" required>
        <span class="form__error"></span>
    </div>
    <div class="form__item<?= ($sign['errors'] && !$sign['name']) ? ' form__item--invalid' : ''; ?>"><!-- form__item--invalid -->
        <label for="name">Имя*</label>
        <input id="name" type="text" name="sign[name]" placeholder="Введите имя" value="<?=htmlspecialchars($sign[0]['name']); ?>" required>
        <span class="form__error"></span>
    </div>
    <div class="form__item<?= ($sign['errors'] && !$sign['contacts']) ? ' form__item--invalid' : ''; ?>"><!-- form__item--invalid -->
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="sign[contacts]" placeholder="Напишите как с вами связаться" required><?=htmlspecialchars($sign[0]['contacts']); ?></textarea>
        <span class="form__error"></span>
    </div>
    <div class="form__item form__item--file <?= $sign[0]['avatar'] ? 'form__item--uploaded' : 'form__item--last'; ?>">
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <input type="hidden" name="sign[avatar]" value="<?= $sign[0]['avatar']; ?>">
                <img src="<?=$sign[0]['avatar']; ?>" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" name="userImage" type="file" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
