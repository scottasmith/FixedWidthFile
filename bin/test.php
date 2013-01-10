#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FixedWidthFile\Specification\Field;
use FixedWidthFile\Record;

$fieldData  = array(
    array(
        'name'       => 'RecordIdentifier',
        'position'   => 0,
        'length'     => 5,
        'format'     => 'String',
        'validation' => '[[:alnum:]]',
        'defaultValue' => 'DefVal'
    ),
    array(
        'name'       => 'Size',
        'position'   => 5,
        'length'     => '10,2',
        'format'     => 'LMDecimal',
        'validation' => '[[:digit:]]'
    )
);

$record = new Record();

foreach ($fieldData as $data) {
    $field  = new Field($data);
    $record->addField($field);
}

$recordString = $record->buildRecord(array(
    'RecordIdentifier' => 'TST',
    'Size' => '1302299331'
));

$recordData = $record->decodeRecord($recordString);
print_r($recordData);

