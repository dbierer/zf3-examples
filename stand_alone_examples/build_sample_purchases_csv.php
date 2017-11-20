<?php
// demonstrates using zend-db component to bulk load from a spreadsheet

// builds CSV file with random purchases
// "sku","po_num","date","qty","price"
// "11971","1001","2009-05-28 21:03:29","10","40.00"

// init vars
$max = 100;
$fn  = __DIR__ . '/purchases.csv';
$csv = new SplFileObject($fn, 'w');

// set up infrastructure
include __DIR__ . '/vendor/autoload.php';
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

$adapter = new Adapter(include __DIR__ . '/db.config.php');
$table = new TableGateway('products', $adapter);

// get list of SKUs
$list = [];
$count = 0;
foreach ($table->select() as $row) {
    $list[] = $row->sku;
    $count++;
}

// prep data
$count--;
$po_num = date('ymd') . sprintf('%02d', rand(0, 99));
$date = new DateTime('now');

// write out row of labels
$csv->fputcsv(['sku','po_num','date','qty','price']);

// pooulate CSV file
for ($x = 0; $x < $max; $x++) {
    if ($x % 2) {
        $date->sub(new DateInterval('P' . rand(1,9) . 'D'));
    } else {
        $date->add(new DateInterval('P' . rand(1,7) . 'D'));
    }
    $sku = $list[rand(0, $count)];
    $qty = rand(1, 999);
    $price = number_format((rand(0, 99) + (rand(1,99) * .01)), 2);
    $csv->fputcsv([$sku, $po_num, $date->format('Y-m-d H:i:s'), $qty, $price]);
}

unset($csv);
readfile($fn);
