<?php
namespace FixedWidthFile\SpecificationBuilder;

use FixedWidthFile\Specification\Record as SpecificationRecord;
use FixedWidthFile\Specification\Field as SpecificationField;
use FixedWidthFile\Collection\Record as CollectionRecord;
use FixedWidthFile\Collection\Field as CollectionField;

class ArrayBuilder extends BaseBuilder
{
    /**
     * Build field collection
     *
     * @param array $fields
     * @return
     */
    protected function buildFieldCollection($fields)
    {
        $fieldCollection = new CollectionField;
        foreach ($fields as $fieldSpecification)
        {
            $field  = new SpecificationField($fieldSpecification);
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
        $recordCollection = new CollectionRecord;
        foreach ($specifications as $specification)
        {
            $fieldCollection = $this->buildFieldCollection($specification['fields']);

            $recordSpecification = new SpecificationRecord($specification['recordSpecification']);
            $recordSpecification->setFieldCollection($fieldCollection);

            $recordCollection->addRecord($recordSpecification);
        }

        return $recordCollection;
    }
}