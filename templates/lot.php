<nav class="nav">
    <ul class="nav__list container">
        <?php foreach($categories as $category):?>
            <li class="nav__item">
                <a href="index.php?id=<?=$category['id']; ?>"><?=$category['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?=htmlspecialchars($lot['name']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot['image']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category']; ?></span></p>
            <p class="lot-item__description"><?=htmlspecialchars($lot['description']) ; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state" <?= !$bet_block_hidden ? '' : 'style = "visibility : hidden"' ; ?>>
                <div class="lot-item__timer timer">
                    <?= timeLeft($lot['date_end']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$bets[0]['price'] ? $bets[0]['price'] : $lot['price_start']; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$bets[0]['price'] ? ($bets[0]['price'] + $lot['price_increment']) : $lot['price_start']; ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="lot.php?lot_id=<?= $lot[id]; ?>" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" min="<?=$bets[0]['price'] ? ($bets[0]['price'] + $lot['price_increment']) : $lot['price_start']; ?>"
                               name="cost" value="<?=$bets[0]['price'] ? ($bets[0]['price'] + $lot['price_increment']) : $lot['price_start']; ?>">
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
                            <td class="history__price"><?=$bet['price'] . 'р'; ?></td><!-- цена-->
                            <td class="history__time"><?=tsToTimeOrDate($bet['date']); ?></td><!-- дата в человеческом формате-->
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>