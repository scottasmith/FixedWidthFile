<?php
namespace FixedWidthFile\Collection;

use FixedWidthFile\Specification\Record as RecordSpecification;

class Record extends AbstractCollection
{
    /**
     * Add item to collection
     *
     * @param  array|RecordSpecification
     * @return boolean
     */
    public function addRecord($recordSpecification)
    {
        if (is_array($recordSpecification)) {
            $recordSpecification = new RecordSpecification($recordSpecification);
        }

        if (!$this->isRecordSpecification($recordSpecification))
        {
            return;
        }

        $name = $recordSpecification->getName();
        if (!$name || empty($name)) {
            return;
        }

        $this->collection[$name] = $recordSpecification;

        return true;
    }

    public function isRecordSpecification($recordSpecification)
    {
        if (is_array($recordSpecification) || $recordSpecification instanceof RecordSpecification) {
             return true;
        }

        return;
    }
}
