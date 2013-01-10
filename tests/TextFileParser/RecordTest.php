<?php
namespace FixedWidthFile;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Field,
    FixedWidthFile\Record;

class RecordTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new Record;
        parent::setUp();
    }

    protected function getFieldData()
    {
        return array(
            'name'       => 'RecordIdentifier',
            'position'   => 0,
            'length'     => 5,
            'format'     => 'String',
            'validation' => '[[:alnum:]]',
            'defaultValue' => 'DefVal'
        );
    }

    protected function getMultiFieldData()
    {
        return array(
            array(
                'name'       => 'RecordIdentifier',
                'position'   => 10,
                'length'     => 5,
                'format'     => 'String',
                'validation' => '[[:alnum:]]',
                'defaultValue' => 'DefVal'
            ),
            array(
                'name'       => 'Size',
                'position'   => 0,
                'length'     => '10',
                'format'     => 'Integer',
                'validation' => '[[:digit:]]'
            )
        );
    }

    public function testAddArrayField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $field = $this->getFieldData();

        $this->helper->addField($field);
        $this->assertEquals($this->helper->getFieldCount(), 1);
    }

    public function testAddObjectField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $fieldData = $this->getFieldData();

        $field = new Field($fieldData);

        $this->helper->addField($field);

        $this->assertEquals($this->helper->getFieldCount(), 1);
    }

    public function testRemoveField()
    {
        // addField only allows array of TextFileParse\Specification\Field

        $field = $this->getFieldData();

        $this->helper->addField($field);

        $this->helper->removeField('NonExistantField');
        $this->assertEquals($this->helper->getFieldCount(), 1);

        $this->helper->removeField('RecordIdentifier');
        $this->assertEquals($this->helper->getFieldCount(), 0);
    }

    public function testGetRecords()
    {
        $fieldData = $this->getFieldData();

        $field = new Field($fieldData);
        $this->helper->addField($field);

        $fields = $this->helper->getFields();

        $fieldDataNew = $fields['RecordIdentifier']->toArray();

        $this->assertTrue((string)$fieldDataNew === (string)$fieldData);
    }

    public function testFieldSort()
    {
        $fieldData = $this->getMultiFieldData();

        foreach ($fieldData as $data) {
            $field = new Field($data);
            $this->helper->addField($field);
        }

        $this->helper->sortFields();

        $fields = $this->helper->getFields();

        $this->assertEquals($fields[0]->getPosition(), 0);
        $this->assertEquals($fields[1]->getPosition(), 10);
    }

    public function testFieldValidation()
    {
        $ret = $this->helper->validateField('123abc', '[[:alnum:]]');
        $this->assertTrue($ret);

        $ret = $this->helper->validateField('123%abc', '[[:alnum:]]');
        $this->assertNull($ret);
    }

    public function testCheckGoodData()
    {
        $field = new Field($this->getFieldData());

        $data = array('RecordIdentifier' => '123abc');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertTrue($ret);
    }

    public function testCheckNoData()
    {
        $field = new Field($this->getFieldData());

        $data = array();
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Field RecordIdentifier not provided');
    }

    public function testCheckMandatoryEmptyData()
    {
        $field = new Field($this->getFieldData());
        $field->setMandatory(1);

        $data = array('RecordIdentifier' => '');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Mandatory field RecordIdentifier is empty');
    }

    public function testCheckDataValidation()
    {
        $field = new Field($this->getFieldData());

        $data = array('RecordIdentifier' => '£$£$');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Validation failed on field RecordIdentifier');
    }

    public function testBuildRecord()
    {
        $fieldData = $this->getMultiFieldData();

        foreach ($fieldData as $data) {
            $field  = new Field($data);
            $this->helper->addField($field);
        }

        $this->helper->sortFields();
        $recordString = $this->helper->buildRecord(array(
            'RecordIdentifier' => 'TST',
            'Size' => '0000112233'
        ));

        $this->assertEquals($recordString, '0000112233TST  ');
    }

    public function testDecodeRecord()
    {
        $fieldData = $this->getMultiFieldData();

        foreach ($fieldData as $data) {
            $field  = new Field($data);
            $this->helper->addField($field);
        }

        $this->helper->sortFields();
        $recordString = $this->helper->buildRecord(array(
            'RecordIdentifier' => 'TST',
            'Size' => '0000112233'
        ));

        $recordData = $this->helper->decodeRecord($recordString);

        $this->assertTrue((string)$recordData === (string)$fieldData);
    }
}
