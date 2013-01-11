<?php
namespace FixedWidthFile;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Field,
    FixedWidthFile\Specification\TestSpecifications,
    FixedWidthFile\RecordParser,
    FixedWidthFile\FieldCollection;

class RecordParserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new RecordParser;
        parent::setUp();
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
        $field = new Field(TestSpecifications::getFieldSpecification());

        $data = array('RecordIdentifier' => '123abc');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertTrue($ret);
    }

    public function testCheckNoData()
    {
        $field = new Field(TestSpecifications::getFieldSpecification());

        $data = array();
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Field RecordIdentifier not provided');
    }

    public function testCheckMandatoryEmptyData()
    {
        $field = new Field(TestSpecifications::getFieldSpecification());
        $field->setMandatory(1);

        $data = array('RecordIdentifier' => '');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Mandatory field RecordIdentifier is empty');
    }

    public function testCheckDataValidation()
    {
        $field = new Field(TestSpecifications::getFieldSpecification());

        $data = array('RecordIdentifier' => '£$£$');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Validation failed on field RecordIdentifier');
    }

    public function testBuildRecord()
    {
        $fieldSpecifications = TestSpecifications::getFieldSpecifications();

        $fieldCollection = new FieldCollection();
        foreach ($fieldSpecifications as $fieldSpecification) {
            $field  = new Field($fieldSpecification);
            $fieldCollection->addField($field);
        }

        $fieldCollection->sortFields();

        $this->helper->setFieldCollection($fieldCollection);
        $recordString = $this->helper->buildRecord(array(
            'RecordIdentifier' => 'TST',
            'Size' => '0000112233'
        ));

        $this->assertEquals($recordString, '0000112233TST  ');
    }

    public function testDecodeRecord()
    {
        $fieldSpecifications = TestSpecifications::getFieldSpecifications();

        $fieldCollection = new FieldCollection();
        foreach ($fieldSpecifications as $fieldSpecification) {
            $field  = new Field($fieldSpecification);
            $fieldCollection->addField($field);
        }

        $fieldCollection->sortFields();

        $this->helper->setFieldCollection($fieldCollection);

        $data = array(
            'RecordIdentifier' => 'TST',
            'Size' => '0000112233'
        );

        $recordString = $this->helper->buildRecord($data);

        $recordData = $this->helper->decodeRecord($recordString);

        $this->assertTrue((string)$recordData === (string)$data);
    }
}
