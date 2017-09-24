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
  <form class="form container <?= ($login['fix_error'] || $login['wrong_data']) ? 'form--invalid' : ''; ?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
      <?=$login['fix_error'] ? '<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме</span>' : ''; ?>
      <?=$login['wrong_data'] ? '<span class="form__error form__error--bottom">Вы ввели неверный email/пароль</span>' : ''; ?>
    <div class="form__item <?= ($login['fix_error'] && !$login['email']) ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="login[email]" placeholder="Введите e-mail" value="<?=htmlspecialchars($login['email']); ?>" required>
      <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item form__item--last <?= ($login['fix_error'] && !$login['password']) ? 'form__item--invalid' : ''; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="login[password]" placeholder="Введите пароль" required>
      <span class="form__error">Введите пароль</span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>