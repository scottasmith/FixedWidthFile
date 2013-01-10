<?php
namespace FixedWidthFile\Specification;

class Field
{
    /**
     * File Name
     * @var string
     */
    protected $name;

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
     * Constructor
     *
     * @param array (optional)
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
     * @throws Exception
     */
    public function fromArray($data)
    {
        if (!is_array($data)) {
            throw new \Exception('data is not an Array');
        }

        $mandatoryFields = array('name', 'position', 'length', 'format', 'validation');

        foreach (get_object_vars($this) as $name => $value) {
            if (in_array($name, $mandatoryFields) && !array_key_exists($name, $data)) {
                throw new \Exception("Mandatory field '$name' does not exist");
            }

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
     * Get the files name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

