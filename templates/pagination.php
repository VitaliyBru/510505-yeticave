<?php if ($pages['count'] > 1): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php foreach ($pages['list'] as $page): ?>
            <?php if ($pages['current'] == $page): ?>
                <li class="pagination-item pagination-item-active"><a><?= $page; ?></a></li>
            <?php else:; ?>
                <li class="pagination-item"><a href="index.php?<?= $id ? "id=$id&" : "" ; ?>page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
<?php endif; ?>