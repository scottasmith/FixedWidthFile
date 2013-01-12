#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FixedWidthFile\Specification;
use FixedWidthFile\Collection;
use FixedWidthFile\RecordParser;
use FixedWidthFile\SpecificationBuilder\ArrayBuilder;

$records = include 'config.php';

$builder = new ArrayBuilder;
$recordCollection = $builder->build($records);

$testRecords = array(
    array(
        'identifier' => 'LINESPEC2',
        'fields'     => array(
            'SomeField2' => 'ID2',
            'Size'       => '1302299331'
        )
    ),
    array(
        'identifier' => 'LINESPEC1',
        'fields'     => array(
            'SomeField1' => 'TST1',
            'KeyField'   => 1,
            'Size'       => '11'
        )
    ),
    array(
        'identifier' => 'LINESPEC1',
        'fields'     => array(
            'SomeField1' => 'TST1',
            'KeyField'   => 2,
            'Size'       => '22222'
        )
    ),
    array(
        'identifier' => 'LINESPEC1',
        'fields'     => array(
            'SomeField1' => 'TST1',
            'KeyField'   => 2,
            'Size'       => '33333'
        )
    )
);

echo "Encode: -\n\n";

print_r($testRecords);

$lineArray = array();
foreach ($testRecords as $recordItem) {

    $recordSpecification = $recordCollection->find($recordItem['identifier']);
    if (!$recordSpecification)
    {
        echo "Cannot find specification: {$recordItem['identifier']}\n\n";
        exit;
    }

    $parser = new RecordParser;
    $parser->setRecordSpecification($recordSpecification);
    $recordString = $parser->buildRecord($recordItem['fields']);

    $lineArray[] = $recordString;
};

echo implode($lineArray, "\n");
echo "\n\n";

echo "Decode: -\n\n";

$lineData = array();
foreach ($lineArray as $line)
{
    $recordSpecification = $recordCollection->find($line);
    if (!$recordSpecification)
    {
        echo "Cannot find specification: $recordName\n\n";
        exit;
    }

    $recordName = $recordSpecification->getName();
    $line = substr($line, strLen($recordName));

    $parser = new RecordParser;
    $parser->setRecordSpecification($recordSpecification);
    $data = $parser->decodeRecord($line);

    $lineData[] = array(
        'identifier' => $recordName,
        'fields'     => $data
    );
}

print_r($lineData);
