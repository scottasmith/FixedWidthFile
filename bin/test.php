#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FixedWidthFile\Specification\Builder\Factory as BuilderFactory;
use FixedWidthFile\EncodeFile;
use FixedWidthFile\DecodeFile;

$testRecords = include 'TestRecords.php';
$arraySpecification = include 'TestArraySpecification.php';
$xmlSpecificationFile = 'TestFile.xml';
include 'TestClassSpecification.php';

try {
    //$builder = BuilderFactory::createArrayBuilder($arraySpecification);
    //$builder = BuilderFactory::createXmlBuilder($xmlSpecificationFile);
    $builder = BuilderFactory::createClassBuilder(new TestClassSpecification);
}
catch(Exception $ex) {
    die('Error: ' . $ex->getMessage() . "\n\n\n");
}

$recordCollection = $builder->getRecordCollection();

echo "Encode: -\n\n";

$encode = new EncodeFile;
$encode->setRecordCollection($recordCollection);
$linesArray = $encode->encode($testRecords);
$linesString = implode("\n", $linesArray);
echo $linesString;

echo "\n\n";
echo "Decode: -\n\n";

$decode = new DecodeFile;
$decode->setRecordCollection($recordCollection);
$data = $decode->decode($linesString);
print_r($data);
