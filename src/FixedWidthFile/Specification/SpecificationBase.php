<?php
namespace FixedWidthFile\Specification;

class SpecificationBase
{
    /**
     * File Name
     * @var string
     */
    protected $name;

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
     */
    public function fromArray($data)
    {
        if (!is_array($data)) {
            return;
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
}