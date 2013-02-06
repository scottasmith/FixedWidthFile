<?php
namespace FixedWidthFile\Specification\Builder;

use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Collection\Field as FieldCollection;
use FixedWidthFile\Specification\Builder\Exception\Exception;

class ArrayBuilder extends AbstractBuilder
{
    public function buildRecordCollectionFromArray($specificationArray)
    {
        foreach($specificationArray as $specificationLineArray) {
            $recordSpecification = $this->getRecordSpecificationFromArray($specificationLineArray);
            $this->recordCollection->addRecord($recordSpecification);
        }
    }

    /**
     * @param array
     * @return RecordSpecification
     */
    protected function getRecordSpecificationFromArray($specificationLineArray)
    {
        $recordSpecificationArray = $this->getValue($specificationLineArray, 'recordSpecification');

        $name = $this->getValue($recordSpecificationArray, 'name');

        $recordSpecification = new RecordSpecification;
        $recordSpecification->setName($name);
        $recordSpecification->setRecordDescription($this->getValue($recordSpecificationArray, 'description'));
        $recordSpecification->setRecordPriority($this->getValue($recordSpecificationArray, 'priority'));
        $recordSpecification->setRecordKeyField($this->getValue($recordSpecificationArray, 'keyField'));

        if (!array_key_exists('fields', $specificationLineArray)) {
            throw new Exception("No fields defined for record $name");
        }

        $fieldArray = $specificationLineArray['fields'];
        $fieldCollection = $this->getFieldCollectionFromArray($fieldArray);
        $recordSpecification->setFieldCollection($fieldCollection);

        return $recordSpecification;
    }

    /**
     * Build field collection
     *
     * @param array
     * @return array
     */
    protected function getFieldCollectionFromArray($fieldArray)
    {
        $fieldCollection = new FieldCollection;

        foreach ($fieldArray as $fieldSpecificationArray) {
            $fieldSpecification = $this->getFieldSpecificationFromArray($fieldSpecificationArray);
            $fieldCollection->addField($fieldSpecification);
        }

        return $fieldCollection;
    }

    /**
     * @param DOMNode
     * @return FieldSpecification|NULL
     */
    protected function getFieldSpecificationFromArray($fieldArray)
    {
        $name = $this->getValue($fieldArray, 'name');

        $fieldSpecification = new FieldSpecification;

        $fieldSpecification->setName($name);
        $fieldSpecification->setFieldPosition($this->getValue($fieldArray, 'position'));
        $fieldSpecification->setFieldLength($this->getValue($fieldArray, 'length'));
        $fieldSpecification->setFieldFormat($this->getValue($fieldArray, 'format'));
        $fieldSpecification->setFieldDefaultValue($this->getValue($fieldArray, 'defaultValue', true));
        $fieldSpecification->setFieldValidation($this->getValue($fieldArray, 'validation'));
        $mandatory = $this->getValue($fieldArray, 'mandatory', true);
        $fieldSpecification->setMandatoryField($mandatory ? true : false);

        return $fieldSpecification;
    }

    /**
     * @param array
     * @param string
     * @param boolean
     */
    protected function getValue($source, $key, $nullOk = false)
    {
        if (!array_key_exists($key, $source) && !$nullOk) {
            throw new Exception("Cannot find value for $key in array");
        }

        return !array_key_exists($key, $source) ? '' : $source[$key];
    }
}
