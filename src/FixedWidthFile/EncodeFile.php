<?php
namespace FixedWidthFile;

use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Exception\ParserException;
use FixedWidthFile\Formatters\FormatterInterface;

class EncodeFile
{
    /**
     * @var RecordCollection
     */
    protected $recordCollection;

    /**
     * @param RecordCollection
     */
    public function setRecordCollection(RecordCollection $recordCollection)
    {
        $this->recordCollection = $recordCollection;
    }

    /**
     * @return RecordCollection
     */
    public function getRecordCollection()
    {
        if (!$this->recordCollection) {
            throw new ParserException('Record collection is not set');
        }

        return $this->recordCollection;
    }

    /**
     * @param array
     * @return string
     * @throws ParserException
     */
    public function encode($multiRecordArray)
    {
        $lineArray = array();

        foreach ($multiRecordArray as $recordArray) {
            $lineArray[] = $this->buildRecord($recordArray);
        }

        $lineArray = $this->sortRecordsByPriority($lineArray);

        array_walk($lineArray, function(&$retArray) {
            $retArray = $retArray['line'];
        });

        return $lineArray;
    }

    /**
     * @param array
     * @return array
     */
    public function sortRecordsByPriority($lineArray)
    {
        usort($lineArray, function($a, $b) {
            if ($a['priority'] == $b['priority']) {
                return 0;
            }

            return ($a['priority'] > $b['priority']) ? 1 : -1;
        });

        return $lineArray;
    }

    /**
     * @param array
     * @return array
     * @throws ParserException
     */
    public function buildRecord($recordArray)
    {
        $recordSpecification = $this->findRecordSpecification($recordArray['identifier']);

        $fieldCollection = $recordSpecification->getFieldCollection();
        $fieldCollection->sortFields();

        $recordString = $recordSpecification->getName();

        foreach ($fieldCollection as $fieldSpecification) {
            $recordString .= $this->buildField($fieldSpecification, $recordArray['fields']);
        }

        $lineArray = array(
            'line' => $recordString,
            'priority' => $recordSpecification->getRecordPriority()
        );

        return $lineArray;
    }

    /**
     * @param string
     * @return RecordSpecification
     */
    public function findRecordSpecification($identifier)
    {
        $recordCollection = $this->getRecordCollection();
        $recordSpecification = $recordCollection->findItemByName($identifier);

        if (!$recordSpecification)
        {
            throw new ParserException("Cannot find record by name '$identifier'");
        }

        return $recordSpecification;
    }

    /**
     * @param array
     * @return string
     * @throws ParserException
     */
    public function buildField(FieldSpecification $fieldSpecification, $fieldArray)
    {
        $name         = $fieldSpecification->getName();
        $defaultValue = $fieldSpecification->getFieldDefaultValue();

        if ((!array_key_exists($name, $fieldArray) || empty($fieldArray[$name])) && !empty($defaultValue)) {
            $fieldArray[$name] = $defaultValue;
        }

        $this->verifyFieldValid($fieldSpecification, $fieldArray);

        $fieldFormatter = $this->getFieldFormatter($fieldSpecification->getFieldFormat());
        $fieldString = $fieldFormatter->format($fieldArray[$name], $fieldSpecification->getFieldLength());

        return $fieldString;
    }

    /**
     * @param FieldSpecification
     * @param array
     * @throws ParserException
     */
    public function verifyFieldValid(FieldSpecification $fieldSpecification, $fieldValue)
    {
        $name = $fieldSpecification->getName();

        if (!array_key_exists($name, $fieldValue)) {
            throw new ParserException("Field $name not provided");
        }

        if ($fieldSpecification->getMandatoryField() && trim($fieldValue[$name]) == '') {
            throw new ParserException("Mandatory field $name is empty");
        }

        $validation = $fieldSpecification->getFieldValidation();
        if (!empty($validation) && !$this->validateField($fieldValue[$name], $validation)) {
            throw new ParserException("Validation failed on field $name");
        }
    }

    /**
     * @array string
     * @return FormatterInterface
     */
    public function getFieldFormatter($fieldFormat)
    {
        $fieldFormaterClassName = __NAMESPACE__ . '\\Formatters\\' . $fieldFormat;

        if (!class_exists($fieldFormaterClassName)) {
            throw new ParserException("Can't find field formatter for format $fieldFormaterClassName");
        }

        $fieldFormatter = new $fieldFormaterClassName;
        return $fieldFormatter;
    }

    /**
     * @param string
     * @param string
     */
    public function validateField($value, $regex)
    {
        $regex = '/^' . $regex . '+$/';

        if (!preg_match($regex, $value)) {
            return;
        }

        return true;
    }
}
