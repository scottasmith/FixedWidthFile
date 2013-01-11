#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FixedWidthFile\Specification\Field;
use FixedWidthFile\Specification\Record;
use FixedWidthFile\FieldCollection;
use FixedWidthFile\RecordParser;

$fieldSpecificationList  = array(
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

$fieldCollection = new FieldCollection();

foreach ($fieldSpecificationList as $fieldSpecification) {
    $field  = new Field($fieldSpecification);
    $fieldCollection->addField($field);
}

$recordSpecification = new Record(array(
    'name' => 'TestLine',
    'description' => 'TestDescription',
    'priority' => 1,
    'keyField' => 'RecordIdentifier'
));


$recordParser = new RecordParser;
$recordParser->setFieldCollection($fieldCollection);
$recordParser->setRecordSpecification($recordSpecification);

$recordString = $recordParser->buildRecord(array(
    'RecordIdentifier' => 'TST',
    'Size' => '1302299331'
));

$recordData = $recordParser->decodeRecord($recordString);
print_r($recordData);
