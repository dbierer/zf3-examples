<?php
// demonstrates using zend-db component to create a temp table of ISO country codes
// thanks to Pierre-Luc Soucy for the nicely formatted data
// http://blog.plsoucy.com/2012/04/iso-3166-country-code-list-csv-sql/

include __DIR__ . '/vendor/autoload.php';

use Zend\Db\Sql\ {Sql, Ddl, Where};
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

// creating this temporary table:
/*
CREATE TABLE `countries` (
  `code` char(2),
  `name` varchar(64),
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

// create the temporary table: 2nd param TRUE == temp table
$ddl = new Ddl\CreateTable('countries', TRUE);

// create columns
$ddl->addColumn(new Ddl\Column\Char('code', 2));
$ddl->addColumn(new Ddl\Column\Varchar('name', 64));
$ddl->addConstraint(new Ddl\Constraint\PrimaryKey('code'));

// Run the DDL statement
$adapter = new Adapter(include __DIR__ . '/db.config.php');
$sql = new Sql($adapter);
$adapter->query($sql->getSqlStringForSqlObject($ddl), Adapter::QUERY_MODE_EXECUTE);


// create table gateway
$table = new TableGateway('countries', $adapter);

// insert country data from CSV
$fileObj = new SplFileObject(__DIR__ . '/countries.csv');

// skim off top row (titles)
$csv = $fileObj->fgetcsv();

while ($csv = $fileObj->fgetcsv()) {
    if (!empty($csv[0])) $table->insert(['code' => $csv[0], 'name' => $csv[1]]);
}

// run a query
$where = new Where();

$output = 'Code | Country ' . PHP_EOL;
$output .= '------------------------------------' . PHP_EOL;
foreach ($table->select($where->like('name', 'T%')) as $row) {
    $output .= sprintf('%4s | %s' . PHP_EOL, $row->code, $row->name);
}
echo $output;
