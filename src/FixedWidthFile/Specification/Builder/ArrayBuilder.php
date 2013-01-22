<?php
namespace FixedWidthFile\Specification\Builder;

use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Collection\Field as FieldCollection;

class ArrayBuilder implements BuilderInterface
{
    // @var RecordCollection
    protected $recordCollection;

    public function __construct()
    {
        $this->recordCollection = new RecordCollection;
    }

    public function getRecordCollection()
    {
        return $this->recordCollection;
    }

    public function buildRecordCollectionFromArray($specificationArray)
    {
        foreach($specificationArray as $specificationLineArray)
        {
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
        $fieldArray = $specificationLineArray['fields'];
        $recordSpecification = $specificationLineArray['recordSpecification'];

        $fieldCollection = $this->getFieldCollectionFromArray($fieldArray);

        $recordSpecification = new RecordSpecification($recordSpecification);
        $recordSpecification->setFieldCollection($fieldCollection);

        return $recordSpecification;
    }

    /**
     * Build field collection
     *
     * @param array $fields
     * @return array
     */
    protected function getFieldCollectionFromArray($fields)
    {
        $fieldCollection = new FieldCollection;

        foreach ($fields as $fieldSpecification)
        {
            $field  = new FieldSpecification($fieldSpecification);
            $fieldCollection->addField($field);
        }

        return $fieldCollection;
    }
}
