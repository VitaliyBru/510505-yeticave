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
<form class="form form--add-lot container <?= $form_valid ? '' : 'form--invalid'; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= $add_item_form['lot_name']['valid'] ? '' : 'form__item--invalid'; ?>" <!-- form__item--invalid -->
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" value="<?=htmlspecialchars($add_item_form['lot_name']['value']); ?>" required>
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item <?= $add_item_form['category']['valid'] ? '' : 'form__item--invalid'; ?>"><!--.form__item--invalid-->
            <label for="category">Категория</label>
            <select id="category" name="category">
                <option>Выберите категорию</option>
                <option <?= ($add_item_form['category']['value'] == 'Доски и лыжи') ? 'selected' : ''; ?>>Доски и лыжи</option>
                <option <?= ($add_item_form['category']['value'] == 'Крепления') ? 'selected' : ''; ?>>Крепления</option>
                <option <?= ($add_item_form['category']['value'] == 'Ботинки') ? 'selected' : ''; ?>>Ботинки</option>
                <option <?= ($add_item_form['category']['value'] == 'Одежда') ? 'selected' : ''; ?>>Одежда</option>
                <option <?= ($add_item_form['category']['value'] == 'Инструменты') ? 'selected' : ''; ?>>Инструменты</option>
                <option <?= ($add_item_form['category']['value'] == 'Разное') ? 'selected' : ''; ?>>Разное</option>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= $add_item_form['message']['valid'] ? '' : 'form__item--invalid'; ?>"><!--form__item--invalid-->
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота" required><?=htmlspecialchars($add_item_form['message']['value']); ?></textarea>
        <span class="form__error">Заполните это поле</span>
    </div>
    <div class="form__item form__item--file <?= $add_item_form['img_url']['valid'] ? 'form__item--uploaded' : ''; ?>"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?=htmlspecialchars($add_item_form['img_url']['value']); ?>" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="userImage" value="" required>
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= $add_item_form['lot_rate']['valid'] ? '' : 'form__item--invalid'; ?>"><!--.form__item--invalid-->
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot_rate" placeholder="0" value="<?=$add_item_form['lot_rate']['value']; ?>" required>
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item form__item--small <?= $add_item_form['lot_step']['valid'] ? '' : 'form__item--invalid'; ?>"><!--.form__item--invalid-->
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot_step" placeholder="0" value="<?=$add_item_form['lot_step']['value']; ?>" required>
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item <?= $add_item_form['lot_date']['valid'] ? '' : 'form__item--invalid'; ?>"><!--.form__item--invalid-->
            <label for="lot-date">Дата завершения</label>
            <input class="form__input-date" id="lot_date" type="text" name="lot_date" placeholder="20.05.2017" value="<?=htmlspecialchars($add_item_form['lot_date']['value']); ?>" required>
            <span class="form__error">Укажите коректную дату</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>