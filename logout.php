<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 08.09.2017
 * Time: 23:15
 */
header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
setcookie('username', '', time() - 3600);
exit();