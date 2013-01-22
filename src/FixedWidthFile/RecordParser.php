<?php
namespace FixedWidthFile;

use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Exception\ParserException;
use FixedWidthFile\Collection;

class RecordParser
{
    /**
     * Record specification
     * @var RecordSpecification
     */
    protected $recordSpecification;

    /**
     * Formatters
     * @var array
     */
    protected $formatters = array('Integer', 'LMDecimal', 'String');

    /**
     * Set record specification
     *
     * @param RecordSpecification
     */
    public function setRecordSpecification(RecordSpecification $recordSpecification)
    {
        $this->recordSpecification = $recordSpecification;
    }

    /**
     * Get record specification
     *
     * @return RecordSpecification
     */
    public function getRecordSpecification()
    {
        return $this->recordSpecification;
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
     * @param  FieldSpecification
     * @param  array $data
     * @param  string error string (out)
     * @return boolean (true - success)
     */
    public function checkData(FieldSpecification $field, $data, &$errorString)
    {
        $name = $field->getName();

        if (!array_key_exists($name, $data)) {
            $errorString = "Field $name not provided";
            return;
        }

        if ($field->getMandatoryField() && trim($data[$name]) == '') {
            $errorString = "Mandatory field $name is empty";
            return;
        }

        if (!$this->validateField($data[$name], $field->getFieldValidation())) {
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
     * @throws ParserException
     */
    public function buildRecord($data)
    {
        $recordSpecification = $this->getRecordSpecification();
        if (!$recordSpecification) {
            throw new ParserException('Record Specification is not set');
        }

        $fieldCollection = $recordSpecification->getFieldCollection();
        if (!$fieldCollection) {
            throw new ParserException('Field Collection is not set');
        }

        $fieldCollection->sortFields();

        $record = $recordSpecification->getName();

        foreach ($fieldCollection as $field) {
            $name         = $field->getName();
            $defaultValue = $field->getFieldDefaultValue();

            if ((!array_key_exists($name, $data) || empty($data[$name])) && !empty($defaultValue)) {
                $data[$name] = $defaultValue;
            }

            if (!$this->checkData($field, $data, $errorString)) {
                throw new ParserException('Failed to build record - ' . $errorString);
            }

            $format = $field->getFieldFormat();
            if (!in_array($format, $this->formatters)) {
                throw new ParserException("Can't find field formatter for format $format");
            }

            $fieldFormatterName = __NAMESPACE__ . '\\Formatters\\' . $format;

            $fieldFormatter = new $fieldFormatterName;
            $fieldValue = $fieldFormatter->format($data[$name], $field->getFieldLength());

            $record .= $fieldValue;
        }

        return $record;
    }

    /**
     * Decode Record
     *
     * @param string $record
     * @return array
     * @throws ParserException
     */
    public function decodeRecord($record)
    {
        if (!is_string($record)) {
            throw new ParserException('Value given is not a string');
        }

        $data = array();
        $recordLength = strlen($record);

        $recordSpecification = $this->getRecordSpecification();
        if (!$recordSpecification) {
            throw new ParserException('Record Specification is not set');
        }

        $fieldCollection = $recordSpecification->getFieldCollection();
        if (!$fieldCollection) {
            throw new ParserException('Field Collection is not set');
        }

        $fieldCollection->sortFields();

        foreach ($fieldCollection as $name => $field) {
            $position = $field->getFieldPosition();
            $length   = $field->getFieldLength();

            $lengths = explode(',', $length);
            if (count($lengths) > 1) {
                $length = $lengths[0] + $lengths[1];
            }

            if ($position > $recordLength || ($position + $length) > $recordLength) {
                throw new \ParserException('Invalid record length or record specifiction');
            }

            $value = substr($record, $position, $length);

            $data[$field->getName()] = $value;
        }

        return $data;
    }
}
