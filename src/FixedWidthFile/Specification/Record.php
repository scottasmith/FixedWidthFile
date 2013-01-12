<?php
namespace FixedWidthFile\Specification;

use FixedWidthFile\Collection\Field as FieldCollection;

class Record extends SpecificationBase
{
    /**
     * Fields
     * @var Collection\FieldCollection
     */
    protected $fieldCollection;

    /**
     * File Description
     * @var string
     */
    protected $description;

    /**
     * Priority
     * @var integer
     */
    protected $priority;

    /**
     * Key Field
     * @var string
     */
    protected $keyField;

    /**
     * Set field collection
     *
     * @param FieldCollection
     */
    public function setFieldCollection(FieldCollection $fieldCollection)
    {
        $this->fieldCollection = $fieldCollection;
    }

    /**
     * Get field collection
     *
     * @return FieldCollection
     */
    public function getFieldCollection()
    {
        return $this->fieldCollection;
    }

    /**
     * Set the files description
     *
     * @param string
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the files description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the priority
     *
     * @param integer
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get the priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the key field
     *
     * @param string
     */
    public function setKeyField($keyField)
    {
        $this->keyField = $keyField;
    }

    /**
     * Get the key field
     *
     * @return string
     */
    public function getKeyField()
    {
        return $this->keyField;
    }
}