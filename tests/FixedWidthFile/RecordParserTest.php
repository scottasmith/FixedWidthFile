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

        $this->assertEquals($recordSpec->getName(), $recordSpec2->getName(),
                            'Record specification names doe not match');
    }

    public function testFieldValidation()
    {
        $ret = $this->helper->validateField('123abc', '[[:alnum:]]');
        $this->assertTrue($ret, 'Validation of \'123abc\' failed');

        $ret = $this->helper->validateField('123%abc', '[[:alnum:]]');
        $this->assertNull($ret, 'Validation of \'123%abc\' failed');
    }

    public function testCheckGoodData()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());

        $data = array('RecordIdentifier' => '123abc');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertTrue($ret, 'checkData failed');
    }

    public function testCheckNoData()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());

        $data = array();
        $ret = $this->helper->checkData($field, $data, $errorString);

        $this->assertNull($ret, 'checkData did not fail');
        $this->assertEquals($errorString, 'Field RecordIdentifier not provided',
                            'Didnt get failed message');
    }

    public function testCheckMandatoryEmptyData()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());
        $field->setMandatory(1);

        $data = array('RecordIdentifier' => '');
        $ret = $this->helper->checkData($field, $data, $errorString);

        $this->assertNull($ret, 'checkData did not fail');
        $this->assertEquals($errorString, 'Mandatory field RecordIdentifier is empty',
                            'Didnt get failed message');
    }

    public function testCheckDataValidation()
    {
        $field = new FieldSpecification(TestSpecifications::getFieldSpecification());

        $data = array('RecordIdentifier' => '£$£$');
        $ret = $this->helper->checkData($field, $data, $errorString);
        $this->assertNull($ret, 'checkData did not fail');
        $this->assertEquals($errorString, 'Validation failed on field RecordIdentifier',
                            'Didnt get failed message');
    }

    private function prepareRecodSpecification()
    {
        $specification = TestSpecifications::getRecordLine();

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

        $this->assertEquals($recordString, 'LINESPEC1TST  00112233',
                            'buildRecord did not build correct line');
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

        $this->assertTrue((string)$recordData === (string)$data,
                          'Original array and returned array  are not the same');
    }
}
