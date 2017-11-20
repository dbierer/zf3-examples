<?php
// demonstrates using zend-db component to bulk load from a spreadsheet
// You could use Zend\Db\Tablegateway\Tablegateway::insert + a statement prepared using Zend\Db\Sql ... but performance is not good
// see matthew weier o'phinney's comments dated 31 May 2017 here: https://discourse.zendframework.com/t/bulk-insert-zend-db/106/2

/**
 * need a function which tests incoming data
 * to make sure key columns are present and in the expected form
 *
 * @param array $row
 * @return boolean TRUE == ok to insert this row
 */
function testRow(array $row)
{
    // in this example, we test column 0 to make sure it is set
    // and has a non-zero integer value
    return (isset($row[0]) && ((int) $row[0]));
}

// init vars
$max = 100;
$fn  = __DIR__ . '/purchases.csv';
$csv = new SplFileObject($fn, 'r');
$table = 'purchases';
$labels = TRUE;     // TRUE if 1st row of CSV == labels

// read 1st CSV row == labels
if ($labels) $csv->fgetcsv();

// maps csv columns to database columns
$mapping = [
    1 => 'sku',
    2 => 'po_num',
    3 => 'date',
    4 => 'qty',
    5 => 'price',
];

// set up infrastructure
include __DIR__ . '/vendor/autoload.php';
$adapter = new \Zend\Db\Adapter\Adapter(include __DIR__ . '/db.config.php');
$pdo     = $adapter->getDriver()->getConnection();

// build SQL statement
$sql     = 'INSERT INTO ' . $table . ' '
         . '(' . implode(',', $mapping) . ') '
         . ' VALUES '
         . '(' . str_repeat('?,', count($mapping)) . ')';

// sanitize SQL
$sql     = str_replace(',)', ')', $sql);

echo $sql . PHP_EOL;

// prepare statement
$stmt    = $pdo->prepare($sql);
$count   = 0;
$success = 0;

// execute in loop
while ($row = $csv->fgetcsv()) {
    // only insert data where column 0 is set and is a integer value > 0
    if (testRow($row)) {
        $count++;
        if ($stmt->execute($row)) {
            $success++;
        }
    }
}

$status = ($count == $success) ? 'SUCCESS' : 'ERROR';
echo $status . ': inserted ' . $success . ' rows out of ' . $count;

