<?php
namespace FixedWidthFile\SpecificationBuilder;

use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Collection\Field as FieldCollection;

class ArrayBuilder extends BaseBuilder
{
    /**
     * Build field collection
     *
     * @param array $fields
     * @return array
     */
    public function buildFieldCollection($fields)
    {
        $fieldCollection = new FieldCollection;
        foreach ($fields as $fieldSpecification)
        {
            $field  = new FieldSpecification($fieldSpecification);
            $fieldCollection->addField($field);
        }

        return $fieldCollection;
    }

    /**
     * Build Specifications from array
     *
     * @param array $specifications
     */
    public function build($specifications)
    {
        $recordCollection = new RecordCollection;
        foreach ($specifications as $specification)
        {
            $fieldCollection = $this->buildFieldCollection($specification['fields']);

            $recordSpecification = new RecordSpecification($specification['recordSpecification']);
            $recordSpecification->setFieldCollection($fieldCollection);

            $recordCollection->addRecord($recordSpecification);
        }

        return $recordCollection;
    }
}
