<?php
include '../php/mcLogin.php';
echo "Testing checkLogin" . PHP_EOL;
echo checkLogin('john','doe') . PHP_EOL;
echo checkLogin('john') . PHP_EOL;
echo checkLogin('mick') . PHP_EOL;

echo "Testing createUser" . PHP_EOL;
echo createUser('mick','watkins') . PHP_EOL;
echo createUser('bridget') . PHP_EOL;
echo createUser('john','doe') . PHP_EOL;

echo "Testing deleteUser" . PHP_EOL;
echo deleteUser('bridget') . PHP_EOL;
echo deleteUser('mick') . PHP_EOL;
echo deleteUser('doesnt_exist') . PHP_EOL;
?>
