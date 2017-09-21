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
<form class="form form--add-lot container <?= !$add_lot['errors'] ? '' : 'form--invalid'; ?>" action="add.php" method="post"
      enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= (!$add_lot['errors'] || $add_lot['name']) ? '' : 'form__item--invalid'; ?>">
        <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="add_lot[name]" placeholder="Введите наименование лота"
               value="<?= htmlspecialchars($add_lot['name']); ?>">
        <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item <?= (!$add_lot['errors'] || $add_lot['category']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="category">Категория</label>
            <select id="category" name="add_lot[category]">
                <option>Выберите категорию</option>
                <?php foreach ($categories as $category):; ?>
                    <option <?= ($add_lot['category'] == $category) ? 'selected' : ''; ?>><?= $category; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= (!$add_lot['errors'] || $add_lot['description']) ? '' : 'form__item--invalid'; ?>">
        <!--form__item--invalid-->
        <label for="message">Описание</label>
        <textarea id="message" name="add_lot[description]" placeholder="Напишите описание лота"><?= htmlspecialchars($add_lot['description']); ?></textarea>
        <span class="form__error">Заполните это поле</span>
    </div>
    <div class="form__item form__item--file <?= $add_lot['img_url'] ? 'form__item--uploaded' : ''; ?>">
        <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <input type="hidden" name="add_lot[img_url]" value="<?= $add_lot['img_url']; ?>">
                <img src="<?= $add_lot['img_url']; ?>" width="113" height="113"
                     alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="userImage">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= (!$add_lot['errors'] || $add_lot['price_start']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" min="1" name="add_lot[price_start]" placeholder="0"
                   value="<?= $add_lot['price_start']; ?>">
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item form__item--small <?= (!$add_lot['errors'] || $add_lot['price_step']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" min="1" name="add_lot[price_step]" placeholder="0"
                   value="<?= $add_lot['price_step']; ?>">
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item <?= (!$add_lot['errors'] || $add_lot['date_end']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="lot-date">Дата завершения</label>
            <input class="form__input-date" id="lot_date" type="date" min="<?= date('Y-m-d', time() + 86400) ; ?>" name="add_lot[date_end]" placeholder="20.05.2017"
                   value="<?= $add_lot['date_end']; ?>">
            <span class="form__error">Укажите коректную дату</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>