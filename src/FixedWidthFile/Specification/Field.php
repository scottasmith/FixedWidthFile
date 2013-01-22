<?php
namespace FixedWidthFile\Specification;

class Field extends SpecificationBase
{
    // @var integer
    protected $position;

    // @var string
    protected $length;

    // @var string
    protected $format;

    // @var string
    protected $defaultValue;

    // @var string
    protected $validation;

    // @var boolean
    protected $mandatory;

    /**
     * @return integer
     */
    public function getFieldPosition()
    {
        return $this->position;
    }

    /**
     * @param integer
     */
    public function setFieldPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return integer
     */
    public function getFieldLength()
    {
        return $this->length;
    }

    /**
     * @param integer
     */
    public function setFieldLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return integer
     */
    public function getFieldFormat()
    {
        return $this->format;
    }

    /**
     * @param integer
     */
    public function setFieldFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFieldDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param string
     */
    public function setFieldDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getFieldValidation()
    {
        return $this->validation;
    }

    /**
     * @param string
     */
    public function setFieldValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * @return
     */
    public function getMandatoryField()
    {
        return $this->mandatory;
    }

    /**
     * @param string
     */
    public function setMandatoryField($mandatory)
    {
        $this->mandatory = (bool)$mandatory;
    }
}

