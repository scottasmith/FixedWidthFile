<?php
namespace FixedWidthFile;

use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\RecordParser;

class DecodeFile
{
    /**
     * Record collection
     * @var RecordCollection
     */
    protected $recordCollection;

    /**
     * Set record collection
     *
     * @param RecordCollection $recordCollection
     */
    public function setRecordCollection(RecordCollection $recordCollection)
    {
        $this->recordCollection = $recordCollection;
    }

    /**
     * Get record collection
     *
     * @return RecordCollection
     */
    public function getRecordCollection()
    {
        return $this->recordCollection;
    }

    /**
     * Decode using lines
     *
     * @param array $lines
     * @return array
     */
    public function decode($lines)
    {
        $recordCollection = $this->getRecordCollection();
        if (!$recordCollection) {
            throw new \Exception('TODO: new exception : Record collection is not set');
        }

        $lineArray = explode("\n", $lines);

        $lineData = array();
        foreach ($lineArray as $line)
        {
            $recordSpecification = $recordCollection->findItemByName($line);
            if (!$recordSpecification)
            {
                echo "Cannot find specification: $recordName\n\n";
                exit;
            }

            $recordName = $recordSpecification->getName();
            $line = substr($line, strLen($recordName));

            $data = $this->decodeRecord($recordSpecification, $line);

            $lineData[] = array(
                'identifier' => $recordName,
                'fields'     => $data
            );
        }

        return $lineData;
    }

    /**
     * @param string
     * @return array
     * @throws ParserException
     */
    public function decodeRecord($recordSpecification, $record)
    {
        if (!is_string($record)) {
            throw new ParserException('Value given is not a string');
        }

        $data = array();
        $recordLength = strlen($record);

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
