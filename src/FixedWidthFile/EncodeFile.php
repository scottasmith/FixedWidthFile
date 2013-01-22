<?php
namespace FixedWidthFile;

use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\RecordParser;

class EncodeFile
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
     * Encode using data
     *
     * @param array $data
     * @return string
     */
    public function encode($data)
    {
        $recordCollection = $this->getRecordCollection();
        if (!$recordCollection) {
            throw new \Exception('TODO: new exception : Record collection is not set');
        }

        $lineArray = array();

        foreach ($data as $recordItem) {
            // TODO: This needs working on
            //       Need to sort the specification?

            $recordSpecification = $recordCollection->findItemByName($recordItem['identifier']);
            if (!$recordSpecification)
            {
                echo "Cannot find specification: {$recordItem['identifier']}\n\n";
                exit;
            }

            $parser = new RecordParser;
            $parser->setRecordSpecification($recordSpecification);
            $recordString = $parser->buildRecord($recordItem['fields']);

            $lineArray[] = $recordString;
        };

        return implode("\n", $lineArray);
    }
}