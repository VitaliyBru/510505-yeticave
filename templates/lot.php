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
    <h2><?=htmlspecialchars($lots[$lot_id]['name']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lots[$lot_id]['img_url']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=htmlspecialchars($lots[$lot_id]['category']); ?></span></p>
            <p class="lot-item__description"><?=htmlspecialchars($lots[$lot_id]['description']) ; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state" <?= ($is_auth && !$bet_done) ? '' : 'style = "visibility : hidden"' ; ?>>
                <div class="lot-item__timer timer">
                    <?= timeLeft($lots[$lot_id]['date_end']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lots[$lot_id]['price_start']; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= ($bets[0]['price'] + $lots[$lot_id]['price_step']); ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="lot.php?lot_id=<?= $lot_id; ?>" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" min="<?=$lots[$lot_id]['price_start']; ?>" step="<?=$lots[$lot_id]['price_step']; ?>" name="cost" value="<?=$bets[0]['price']; ?>">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= $bets[0]['name'] ? count($bets) : '0'; ?></span>)</h3>
                <!-- заполните эту таблицу данными из массива $bets-->
                <table class="history__list">
                    <?php foreach ($bets as $bet): ?>
                        <tr class="history__item">
                            <td class="history__name"><?=$bet['name']; ?></td><!-- имя автора-->
                            <td class="history__price"><?=$bet['price'] ? $bet['price'] . 'р' : ''; ?></td><!-- цена-->
                            <td class="history__time"><?=$bet['ts'] ? tsToTimeOrDate($bet['ts']) : ''; ?></td><!-- дата в человеческом формате-->
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>