<?php
include '../php/mcLogin.php';
echo checkLogin('john','doe') . PHP_EOL;
echo checkLogin('john') . PHP_EOL;
echo checkLogin('mick') . PHP_EOL;
?>
