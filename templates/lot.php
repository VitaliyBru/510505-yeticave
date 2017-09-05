<nav class="nav">
    <ul class="nav__list container">
        <li class="nav__item">
            <a href="">Доски и лыжи</a>
        </li>
        <li class="nav__item">
            <a href="">Крепления</a>
        </li>
        <li class="nav__item">
            <a href="">Ботинки</a>
        </li>
        <li class="nav__item">
            <a href="">Одежда</a>
        </li>
        <li class="nav__item">
            <a href="">Инструменты</a>
        </li>
        <li class="nav__item">
            <a href="">Разное</a>
        </li>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?=htmlspecialchars($lot_name); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$img_url; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=htmlspecialchars($category); ?></span></p>
            <p class="lot-item__description"><?=htmlspecialchars($message) ; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54:12
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lot_rate; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$lot_rate; ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="12 000">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span></span>)</h3>
                <!-- заполните эту таблицу данными из массива $bets-->
                <table class="history__list">
                        <tr class="history__item">
                            <td class="history__name"><!-- имя автора--></td>
                            <td class="history__price"><!-- цена-->р</td>
                            <td class="history__time"><!-- дата в человеческом формате--></td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
</section>