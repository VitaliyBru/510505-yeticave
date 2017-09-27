<nav class="nav">
    <ul class="nav__list container">
        <?php foreach($categories as $category):?>
            <li class="nav__item">
                <a href="index.php?id=<?=$category['id']; ?>"><?=$category['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form form--add-lot container <?= $add_lot['errors'] ? 'form--invalid' : ''; ?>" action="add.php" method="post"
      enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= (!$add_lot['errors'] || $add_lot['value']['name']) ? '' : 'form__item--invalid'; ?>">
        <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="add_lot[name]" placeholder="Введите наименование лота"
               value="<?= htmlspecialchars($add_lot['value']['name']); ?>">
        <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item <?= (!$add_lot['errors'] || $add_lot['value']['category']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="category">Категория</label>
            <select id="category" name="add_lot[category]">
                <option>Выберите категорию</option>
                <?php foreach ($categories as $category):; ?>
                    <option <?= ($add_lot['value']['category'] == $category['name']) ? 'selected' : ''; ?>><?= $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= (!$add_lot['errors'] || $add_lot['value']['description']) ? '' : 'form__item--invalid'; ?>">
        <!--form__item--invalid-->
        <label for="message">Описание</label>
        <textarea id="message" name="add_lot[description]" placeholder="Напишите описание лота"><?= htmlspecialchars($add_lot[0]['description']); ?></textarea>
        <span class="form__error">Заполните это поле</span>
    </div>
    <div class="form__item form__item--file <?= $add_lot['value']['image'] ? 'form__item--uploaded' : ''; ?>">
        <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <input type="hidden" name="add_lot[image]" value="<?= $add_lot['value']['image']; ?>">
                <img src="<?= $add_lot['value']['image']; ?>" width="113" height="113"
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
        <div class="form__item form__item--small <?= (!$add_lot['errors'] || $add_lot['value']['price_increment']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" min="1" name="add_lot[price_start]" placeholder="0"
                   value="<?= $add_lot['value']['price_start']; ?>">
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item form__item--small <?= (!$add_lot['errors'] || $add_lot['value']['price_increment']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" min="1" name="add_lot[price_increment]" placeholder="0"
                   value="<?= $add_lot['value']['price_increment']; ?>">
            <span class="form__error">Заполните это поле</span>
        </div>
        <div class="form__item <?= (!$add_lot['errors'] || $add_lot['value']['date_end']) ? '' : 'form__item--invalid'; ?>">
            <!--.form__item--invalid-->
            <label for="lot-date">Дата завершения</label>
            <input class="form__input-date" id="lot_date" type="date" min="<?= date('Y-m-d', time() + 86400) ; ?>" name="add_lot[date_end]" placeholder="20.05.2017"
                   value="<?= $add_lot['value']['date_end']; ?>">
            <span class="form__error">Укажите коректную дату</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>