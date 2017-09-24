<nav class="nav">
    <ul class="nav__list container">
        <?php foreach($categories as $category):?>
            <li class="nav__item">
                <a href="index.php?id=<?=$category['id']; ?>"><?=$category['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($my_bets as $lot_bet): ?>
        <tr class="rates__item<?= (strtotime($lot_bet['date_end']) > strtotime('now')) ? '' : ' rates__item--end'; ?>">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../<?= $lot_bet['image']; ?>" width="54" height="40" alt="Куртка">
                </div>
                <h3 class="rates__title"><a href="lot.php?lot_id=<?= $lot_bet['lot_id']; ?>"><?= htmlspecialchars($lot_bet['name']); ?></a></h3>
            </td>
            <td class="rates__category">
                <?= htmlspecialchars($lot_bet['category']); ?>
            </td>
            <td class="rates__timer">
                <?php if (strtotime($lot_bet['date_end']) > strtotime('now')): ?>
                <div class="timer timer--finishing"><?= timeLeft ($lot_bet['date_end']); ?></div>
                <?php else: ?>
                <div class="timer timer--end">Торги окончены</div>
                <?php endif; ?>
            </td>
            <td class="rates__price">
                <?= $lot_bet['price']; ?> р
            </td>
            <td class="rates__time">
                <?= tsToTimeOrDate($lot_bet['date']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>