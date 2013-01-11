<?php
namespace FixedWidthFile;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Field,
    FixedWidthFile\Specification\TestSpecifications,
    FixedWidthFile\FieldCollection;

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
        $this->assertEquals(count($this->helper), 1);
    }

    public function testAddObjectField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $fieldSpecification = TestSpecifications::getFieldSpecification();
        $field = new Field($fieldSpecification);

        $this->helper->addField($field);
        $this->assertEquals(count($this->helper), 1);
    }

    public function testRemoveField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $fieldSpecification = TestSpecifications::getFieldSpecification();
        $this->helper->addField($fieldSpecification);

        $this->helper->removeField('NonExistantField');
        $this->assertEquals(count($this->helper), 1);

        $this->helper->removeField('RecordIdentifier');
        $this->assertEquals(count($this->helper), 0);
    }

    public function testGetRecords()
    {
        $fieldSpecification = TestSpecifications::getFieldSpecification();

        $field = new Field($fieldSpecification);
        $this->helper->addField($field);

        $fields = $this->helper->getFields();

        $fieldDataNew = $fields['RecordIdentifier']->toArray();

        $this->assertTrue((string)$fieldDataNew === (string)$fieldSpecification);
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

        $this->assertEquals($fields[0]->getPosition(), 0);
        $this->assertEquals($fields[1]->getPosition(), 10);
    }
}
