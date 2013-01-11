<?php
namespace FixedWidthFile\Specification;

use FixedWidthFile\FieldCollection;

class Record
{
    /**
     * File Name
     * @var string
     */
    protected $name;

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
     * Constructor
     *
     * @param array (optional)
     * @throws SpecificationException
     */
    public function __construct($data = null)
    {
        if (is_array($data)) {
            $this->fromArray($data);
        }
    }

    /**
     * Import from array
     *
     * @param array
     * @throws SpecificationException
     */
    public function fromArray($data)
    {
        if (!is_array($data)) {
            throw new SpecificationException('Data is not an Array');
        }

        $objectVars = get_object_vars($this);
        foreach ($objectVars as $name => $value) {
            if (array_key_exists($name, $data)) {
                $this->$name = $data[$name];
            }
        }
    }

    /**
     * export to array
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * Set the files name
     *
     * @param string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the files name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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