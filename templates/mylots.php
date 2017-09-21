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
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($my_bets as $lot_id => $bet): ?>
        <tr class="rates__item<?= ($lots[$lot_id]['date_end'] > strtotime('now')) ? '' : ' rates__item--end'; ?>">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../<?= $lots[$lot_id]['img_url']; ?>" width="54" height="40" alt="Куртка">
                </div>
                <h3 class="rates__title"><a href="lot.php?lot_id=<?= $lot_id; ?>"><?= htmlspecialchars($lots[$lot_id]['name']); ?></a></h3>
            </td>
            <td class="rates__category">
                <?= htmlspecialchars($lots[$lot_id]['category']); ?>
            </td>
            <td class="rates__timer">
                <?php if ($lots[$lot_id]['date_end'] > strtotime('now')): ?>
                <div class="timer timer--finishing"><?= timeLeft ($lots[$lot_id]['date_end']); ?></div>
                <?php else: ?>
                <div class="timer timer--end">Торги окончены</div>
                <?php endif; ?>
            </td>
            <td class="rates__price">
                <?= $bet['price']; ?> р
            </td>
            <td class="rates__time">
                <?= tsToTimeOrDate($bet['ts']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>