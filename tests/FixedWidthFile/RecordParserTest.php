<?php
namespace FixedWidthFile;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\RecordParser,
    FixedWidthFile\Specification\Field as FieldSpecification,
    FixedWidthFile\Specification\Record as RecordSpecification,
    FixedWidthFile\Specification\TestSpecifications,
    FixedWidthFile\Collection\Field as FieldCollection;

class RecordParserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new RecordParser;
        parent::setUp();
    }

    public function testRecordSpecification()
    {
        $recordSpec = new RecordSpecification;
        $this->helper->setRecordSpecification($recordSpec);

        $recordSpec2 = $this->helper->getRecordSpecification();
        $this->assertEquals($recordSpec->getName(), $recordSpec2->getName());
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
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());

        $data = array('RecordIdentifier' => '123abc');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertTrue($ret);
    }

    public function testCheckNoData()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());

        $data = array();
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Field RecordIdentifier not provided');
    }

    public function testCheckMandatoryEmptyData()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());
        $field->setMandatory(1);

        $data = array('RecordIdentifier' => '');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Mandatory field RecordIdentifier is empty');
    }

    public function testCheckDataValidation()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());

        $data = array('RecordIdentifier' => '£$£$');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret);
        $this->assertEquals($errorString, 'Validation failed on field RecordIdentifier');
    }

    private function prepareRecodSpecification()
    {
        $specification = TestSpecifications::getRecordLines();

        $fieldCollection = new FieldCollection();
        foreach ($specification['fields'] as $fieldSpecification) {
            $field  = new FieldSpecification($fieldSpecification);
            $fieldCollection->addField($field);
        }

        $fieldCollection->sortFields();

        $recordSpecification = new RecordSpecification($specification['recordSpecification']);
        $recordSpecification->setFieldCollection($fieldCollection);

        return $recordSpecification;
    }

    public function testBuildRecord()
    {
        $recordSpecification = $this->prepareRecodSpecification();

        $this->helper->setRecordSpecification($recordSpecification);
        $recordString = $this->helper->buildRecord(array(
            'SomeField1' => 'TST',
            'Size' => '112233'
        ));

        $this->assertEquals($recordString, 'LINESPEC1TST  00112233');
    }

    public function testDecodeRecord()
    {
        $recordSpecification = $this->prepareRecodSpecification();

        $this->helper->setRecordSpecification($recordSpecification);

        $data = array(
            'SomeField1' => 'TST',
            'Size' => '112233'
        );

        $recordString = $this->helper->buildRecord($data);

        $recordData = $this->helper->decodeRecord($recordString);

        $this->assertTrue((string)$recordData === (string)$data);
    }
}
