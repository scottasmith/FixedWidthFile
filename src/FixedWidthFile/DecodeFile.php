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

            $parser = new RecordParser;
            $parser->setRecordSpecification($recordSpecification);
            $data = $parser->decodeRecord($line);

            $lineData[] = array(
                'identifier' => $recordName,
                'fields'     => $data
            );
        }

        return $lineData;
    }
}