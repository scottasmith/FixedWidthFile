#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FixedWidthFile\Specification;
use FixedWidthFile\SpecificationBuilder\ArrayBuilder;
use FixedWidthFile\Collection;
use FixedWidthFile\RecordParser;
use FixedWidthFile\EncodeFile;
use FixedWidthFile\DecodeFile;

$records = include 'config.php';

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

$builder = new ArrayBuilder;
$recordCollection = $builder->build($records);

echo "Encode: -\n\n";

$encode = new EncodeFile;
$encode->setRecordCollection($recordCollection);
$lines = $encode->encode($testRecords);
echo $lines;

echo "\n\n";
echo "Decode: -\n\n";

$decode = new DecodeFile;
$decode->setRecordCollection($recordCollection);
$data = $decode->decode($lines);
print_r($data);
