<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 08.09.2017
 * Time: 23:15
 */
session_start();
$_SESSION = [];
header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
exit();