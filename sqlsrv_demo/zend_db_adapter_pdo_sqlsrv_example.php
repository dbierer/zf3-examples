<?php
include __DIR__ . '/vendor/autoload.php';

use Zend\Db\Adapter\Adapter;

$config = [
    'driver'    => 'PDO',
    'dsn'       => 'sqlsrv:Server=tcp:192.168.3.126,1433;Database=test',
    'user'      => 'test',
    'password'  => 'Password123',
];

try {
    $adapter = new Adapter($config);
    $result = $adapter->query('select * from prospects', []);
    $first = 0;
    echo '<pre>' . PHP_EOL;
    foreach ($result as $row) {
        var_dump($row);
    }
    echo '</pre>';
    echo 'DONE' . PHP_EOL;
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
