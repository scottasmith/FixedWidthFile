<?php
namespace FixedWidthFile\Specification;

use FixedWidthFile\Specification\SpecificationException;

class Field extends SpecificationBase
{
    /**
     * Field Position
     * @var integer
     */
    protected $position;

    /**
     * Field Length
     * @var string
     */
    protected $length;

    /**
     * Field Format
     * @var string
     */
    protected $format;

    /**
     * Default Value
     * @var string
     */
    protected $defaultValue;

    /**
     * Validation Regex
     * @var string
     */
    protected $validation;

    /**
     * Is this field mandatory
     * @var boolean
     */
    protected $mandatory;

    /**
     * Get the field position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the field position
     *
     * @param integer
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get the field length
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set the field length
     *
     * @param integer
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Get the format
     *
     * @return integer
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set the format
     *
     * @param integer
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Get the default value
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set the default value
     *
     * @param string
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Get the validation
     *
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set the validation
     *
     * @param string
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * Get the whether this field is mandatory
     *
     * @return
     */
    public function getMandatory()
    {
        return $this->mandatory;
    }

    /**
     * Set the mandatory
     *
     * @param string
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = (bool)$mandatory;
    }
}

