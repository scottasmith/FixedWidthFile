<?php
use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Collection\Field as FieldCollection;
use FixedWidthFile\Specification\Builder\Exception\Exception;
use FixedWidthFile\Specification\Builder\AbstractBuilder;

class TestClassSpecification extends AbstractBuilder
{
    public function buildRecordCollection()
    {
        $recordSpecification = $this->getFirstRecordSpecification();
        $this->recordCollection->addRecord($recordSpecification);

        $recordSpecification = $this->getSecondRecordSpecification();
        $this->recordCollection->addRecord($recordSpecification);
    }

    /**
     * @return RecordSpecification
     */
    protected function getFirstRecordSpecification()
    {
        $recordSpecification = new RecordSpecification;
        $recordSpecification->setName('LINESPEC1');
        $recordSpecification->setRecordDescription('TestDescriptionSpecification1');
        $recordSpecification->setRecordPriority(1);
        $recordSpecification->setRecordKeyField('KeyField');

        $fieldCollection = $this->getFirstRecordFieldCollection();
        $recordSpecification->setFieldCollection($fieldCollection);

        return $recordSpecification;
    }

    /**
     * Build field collection
     *
     * @return array
     */
    protected function getFirstRecordFieldCollection()
    {
        $fieldCollection = new FieldCollection;

        $fieldSpecification = new FieldSpecification;
        $fieldSpecification->setName('SomeField1');
        $fieldSpecification->setFieldPosition(0);
        $fieldSpecification->setFieldLength(5);
        $fieldSpecification->setFieldFormat('String');
        $fieldSpecification->setFieldDefaultValue('DefVal');
        $fieldSpecification->setFieldValidation('[[:alnum:]]');
        $fieldCollection->addField($fieldSpecification);

        $fieldSpecification = new FieldSpecification;
        $fieldSpecification->setName('KeyField');
        $fieldSpecification->setFieldPosition(5);
        $fieldSpecification->setFieldLength(3);
        $fieldSpecification->setFieldFormat('Integer');
        $fieldSpecification->setFieldValidation('[[:digit:]]');
        $fieldCollection->addField($fieldSpecification);

        $fieldSpecification = new FieldSpecification(array(
            'name' => 'Size',
            'position' => 8,
            'length' => 2,
            'format' => 'Integer',
            'validation' => '[[:digit:]]',
        ));
        $fieldCollection->addField($fieldSpecification);

        return $fieldCollection;
    }

    /**
     * @return RecordSpecification
     */
    protected function getSecondRecordSpecification()
    {
        $recordSpecification = new RecordSpecification;
        $recordSpecification->setName('LINESPEC2');
        $recordSpecification->setRecordDescription('TestDescriptionSpecification2');
        $recordSpecification->setRecordPriority(1);
        $recordSpecification->setRecordKeyField('SomeField2');

        $fieldCollection = $this->getSecondRecordFieldCollection();
        $recordSpecification->setFieldCollection($fieldCollection);

        return $recordSpecification;
    }

    /**
     * Build field collection
     *
     * @return array
     */
    protected function getSecondRecordFieldCollection()
    {
        $fieldCollection = new FieldCollection;

        $fieldSpecification = new FieldSpecification(array(
            'name'       => 'SomeField2',
            'position'   => 0,
            'length'     => 5,
            'format'     => 'String',
            'validation' => '[[:alnum:]]',
            'defaultValue' => 'DefVal'
        ));
        $fieldCollection->addField($fieldSpecification);

        $fieldSpecification = new FieldSpecification;
        $fieldSpecification->setName('Size');
        $fieldSpecification->setFieldPosition(5);
        $fieldSpecification->setFieldLength(2);
        $fieldSpecification->setFieldFormat('Integer');
        $fieldSpecification->setFieldValidation('[[:digit:]]');
        $fieldCollection->addField($fieldSpecification);

        return $fieldCollection;
    }

    /**
     * @param array
     * @param string
     * @param boolean
     */
    protected function getValue($source, $key, $nullOk = false)
    {
    }
}

