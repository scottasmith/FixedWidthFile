<?php
namespace FixedWidthFile;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Field,
    FixedWidthFile\Specification\TestSpecifications,
    FixedWidthFile\Collection\Field as FieldCollection;

class FieldCollectionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new FieldCollection;
        parent::setUp();
    }

    public function testAddArrayField()
    {
        // addField only allows array or TextFileParse\Specification\Field

        $fieldSpecification = TestSpecifications::getFieldSpecification();

        $this->helper->addField($fieldSpecification);

        $this->assertEquals(count($this->helper), 1,
                            'Number of records in collection does not match');
    }

    public function testAddObjectField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $fieldSpecification = TestSpecifications::getFieldSpecification();
        $field = new Field($fieldSpecification);

        $this->helper->addField($field);
        $this->assertEquals(count($this->helper), 1,
                            'Number of records in collection does not match');
    }

    public function testRemoveField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $fieldSpecification = TestSpecifications::getFieldSpecification();
        $this->helper->addField($fieldSpecification);

        $this->helper->remove('NonExistantField');
        $this->assertEquals(count($this->helper), 1,
                            'Number of records in collection does not match');

        $this->helper->remove('RecordIdentifier');
        $this->assertEquals(count($this->helper), 0,
                            'Number of records in collection does not match');
    }

    public function testGetRecords()
    {
        $fieldSpecification = TestSpecifications::getFieldSpecification();

        $field = new Field($fieldSpecification);
        $this->helper->addField($field);

        $fields = $this->helper->getFields();

        $fieldDataNew = $fields['RecordIdentifier']->toArray();

        $this->assertTrue((string)$fieldDataNew === (string)$fieldSpecification,
                          'Returned field specification does not match original');
    }

    public function testFieldSort()
    {
        $fieldSpecifications = TestSpecifications::getFieldSpecifications();

        foreach ($fieldSpecifications as $data) {
            $field = new Field($data);
            $this->helper->addField($field);
        }

        $this->helper->sortFields();

        $fields = $this->helper->getFields();

        $this->assertEquals($fields[0]->getPosition(), 0,
                            'Field 0 position is not valid');
        $this->assertEquals($fields[1]->getPosition(), 10,
                            'Field 0 position is not valid');
    }
}
