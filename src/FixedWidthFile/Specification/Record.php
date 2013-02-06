<?php
namespace FixedWidthFile\Specification;

use FixedWidthFile\Collection\Field as FieldCollection;

class Record extends AbstractSpecification
{
    // @var Collection\FieldCollection
    protected $fieldCollection;

    // @var string
    protected $description;

    // @var integer
    protected $priority;

    // @var string
    protected $keyField;

    /**
     * @param FieldCollection
     */
    public function setFieldCollection(FieldCollection $fieldCollection)
    {
        $this->fieldCollection = $fieldCollection;
    }

    /**
     * @return FieldCollection
     */
    public function getFieldCollection()
    {
        return $this->fieldCollection;
    }

    /**
     * @param string
     */
    public function setRecordDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRecordDescription()
    {
        return $this->description;
    }

    /**
     * @param integer
     */
    public function setRecordPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return integer
     */
    public function getRecordPriority()
    {
        return $this->priority;
    }

    /**
     * @param string
     */
    public function setRecordKeyField($keyField)
    {
        $this->keyField = $keyField;
    }

    /**
     * @return string
     */
    public function getRecordKeyField()
    {
        return $this->keyField;
    }
}
