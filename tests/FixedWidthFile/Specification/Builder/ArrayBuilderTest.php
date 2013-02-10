<?php
namespace FixedWidthFile\SpecificationBuilder;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Builder\ArrayBuilder,
    FixedWidthFile\Specification\TestSpecifications,
    FixedWidthFile\Collection\Field as FieldCollection,
    FixedWidthFile\Collection\Record as RecordCollection;

class ArrayBuilderTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new ArrayBuilder;
        parent::setUp();
    }

    protected function buildAndGetRecordCollection()
    {
        $recordSpecification = TestSpecifications::getRecordLine();

        $this->helper->buildRecordCollectionFromArray($recordSpecification);
        return $this->helper->getRecordCollection();
    }

    public function testRecordCollectionHasSpecification()
    {
        $recordCollectionClass = $this->buildAndGetRecordCollection();
        $recordCollectionArray = $recordCollectionClass->getCollectionArray();

        $this->assertTrue(array_key_exists('LINESPEC1', $recordCollectionArray));
    }

    public function testRecordCollectionHasFieldCollection()
    {
        $recordCollectionClass = $this->buildAndGetRecordCollection();
        $recordCollectionArray = $recordCollectionClass->getCollectionArray();

        $recordSpec1 = $recordCollectionArray['LINESPEC1'];

        $fieldCollectionClass = $recordSpec1->getFieldCollection();

        $this->assertTrue($fieldCollectionClass instanceof FieldCollection,
                          'buildFieldCollection does not return instance of FieldCollection');
    }
}