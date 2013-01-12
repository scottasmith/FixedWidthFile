<?php
namespace FixedWidthFile\SpecificationBuilder;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\SpecificationBuilder\ArrayBuilder,
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

    public function testRecordSpecification()
    {
        $recordLine = TestSpecifications::getRecordLine();
        $fields = $recordLine['fields'];

        $ret = $this->helper->buildFieldCollection($fields);

        $this->assertTrue($ret instanceof FieldCollection,
                          'buildFieldCollection does not return instance of FieldCollection');
    }

    public function testBuild()
    {
        $recordLine = TestSpecifications::getRecordLine();

        $records = array(
            $recordLine
        );

        $ret = $this->helper->build($records);

        $this->assertTrue($ret instanceof RecordCollection,
                          'build does not return instance of RecordCollection');
    }
}