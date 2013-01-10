<?php
namespace FixedWidthFile;

use FixedWidthFile\Specification;

class Record
{
    /**
     * Field in record
     * @var array
     */
    protected $fields = array();

    /**
     * Formatters
     * @var array
     */
    protected $formatters = array('Integer', 'LMDecimal', 'String');

    /**
     * Add field specification to line
     *
     * @param  array|Specification\Field
     * @return fluent interface
     */
    public function addField($field)
    {
        if (!is_array($field) && !$field instanceof Specification\Field) {
            throw new \Exception('Field needs to be either an array or instance of Specification\Field');
        }

        if (is_array($field)) {
            $field = new Specification\Field($field);
        }

        $name = $field->getName();
        if (!$name || empty($name)) {
            throw new \Exception('field name cannot be empty');
        }

        $this->fields[$name] = $field;

        return $this;
    }

    /**
     * Remove field specification from the line
     *
     * @param  string field name
     * @return fluent interface
     */
    public function removeField($name)
    {
        if (array_key_exists($name, $this->fields)) {
            unset($this->fields[$name]);
        }

        return $this;
    }

    /**
     * Get number of fields
     *
     * @return integer
     */
    public function getFieldCount()
    {
        return count($this->fields);
    }

    /**
     * Get fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }


    /**
     * Sort fields by the position
     */
    public function sortFields()
    {
        // Sort the fields by position
        usort($this->fields, function($a, $b) {
            if ($a->getPosition() == $b->getPosition()) {
                return 0;
            }

            return ($a->getPosition() > $b->getPosition()) ? 1 : -1;
        });
    }

    /**
     * Validate field
     *
     * @param string value
     * @param string validation
     */
    public function validateField($value, $validation)
    {
        $validation = '/^' . $validation . '+$/';

        if (!empty($validation) && !preg_match($validation, $value)) {
            return;
        }

        return true;
    }

    /**
     * Check data against fields
     *
     * @param  Specification\Field
     * @param  array $data
     * @param  string error string (out)
     * @return boolean (true - success)
     */
    public function checkData(Specification\Field $field, $data, &$errorString)
    {
        $name = $field->getName();

        if (!array_key_exists($name, $data)) {
            $errorString = "Field $name not provided";
            return;
        }

        if ($field->getMandatory() && trim($data[$name]) == '') {
            $errorString = "Mandatory field $name is empty";
            return;
        }

        if (!$this->validateField($data[$name], $field->getValidation())) {
            $errorString = "Validation failed on field $name";
            return;
        }

        return true;
    }

    /**
     * Build Record
     *
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function buildRecord($data)
    {
        $record = '';

        $this->sortFields();

        foreach ($this->fields as $field) {
            $name         = $field->getName();
            $defaultValue = $field->getDefaultValue();

            if ((!array_key_exists($name, $data) || empty($data[$name])) && !empty($defaultValue)) {
                $data[$name] = $defaultValue;
            }

            if (!$this->checkData($field, $data, $errorString)) {
                throw new \Exception('Failed to build record - ' . $errorString);
            }

            $format = $field->getFormat();
            if (!in_array($format, $this->formatters)) {
                throw new \Exception("Can't find field formatter for format $format");
            }

            $fieldFormatterName = 'TextFileParse\\Formatters\\' . $format;

            $fieldFormatter = new $fieldFormatterName;
            $fieldValue = $fieldFormatter->format($data[$name], $field->getLength());

            $record .= $fieldValue;
        }

        return $record;
    }

    /**
     * Decode Record
     *
     * @param string $record
     * @return array
     * @throws Exception
     */
    public function decodeRecord($record)
    {
        if (!is_string($record)) {
            throw new Exception('Value given is not a string');
        }

        $data = array();
        $recordLength = strlen($record);

        $this->sortFields();

        foreach ($this->fields as $name => $field) {
            $position = $field->getPosition();
            $length   = $field->getLength();

            $lengths = explode(',', $length);
            if (count($lengths) > 1) {
                $length = $lengths[0] + $lengths[1];
            }

            if ($position > $recordLength || ($position + $length) > $recordLength) {
                throw new \Exception('Invalid record length or record specifiction');
            }

            $value = substr($record, $position, $length);

            $data[$field->getName()] = $value;
        }

        return $data;
    }
}
