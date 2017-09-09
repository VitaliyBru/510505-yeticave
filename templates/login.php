<nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  <form class="form container <?= $user_login['form_valid'] ? '' : 'form--invalid'; ?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?= (!$user_login['email'] && !$user_login['form_valid']) ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=htmlspecialchars($user_login['email']); ?>" required>
      <span class="form__error">Вы ввели неверный e-mail</span>
    </div>
    <div class="form__item form__item--last <?= $user_login['form_valid'] ? '' : 'form__item--invalid'; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" required>
      <span class="form__error">Вы ввели неверный пароль</span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>