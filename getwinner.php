<?php
require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

$winner_data = [];
$sql = 'SELECT id FROM lots WHERE winner IS NULL AND date_end < NOW()';
$lots_without_winner = select_data($link, $sql);
$sql = 'SELECT users.id AS user_id, users.name AS user_name, users.email, lots.id AS lot_id, lots.name FROM bets
INNER JOIN lots ON bets.lot_id=lots.id
INNER JOIN users ON bets.user_id=users.id
WHERE lot_id=?
ORDER BY bets.id DESC
LIMIT 1 OFFSET 0';
if ($lots_without_winner) {
    $sql_update = 'UPDATE lots SET winner=? WHERE id=?';
    foreach ($lots_without_winner as $lot_id) {
        $temp = select_data($link, $sql, [$lot_id['id']]);
        exec_query($link, $sql_update, [$temp[0]['user_id'], $lot_id['id']]);
        $winners_data[] = $temp[0];
    }
}

$transport = new Swift_SmtpTransport('smtp.mail.ru', 465 , 'ssl');
$transport->setUsername('doingsdone@mail.ru');
$transport->getPassword('rds7BgcL');
$mailer = new Swift_Mailer($transport);
$message = (new Swift_Message('Ваша ставка победила'))
->setFrom(['doingsdone@mail.ru' => 'yeticave']);
foreach ($winners_data as $winner) {
    $body_content = renderTemplate('email', ['winner' => $winner]);
    $message->setTo([$winner['email']]);
    $message->setBody($body_content);
    $mailer->send($message);
}
