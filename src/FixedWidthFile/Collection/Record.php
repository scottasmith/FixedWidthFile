<?php
namespace FixedWidthFile\Collection;

use FixedWidthFile\Specification\Record as SpecificationRecord;
use FixedWidthFile\Specification\Exception\SpecificationException;

class Record extends CollectionBase
{
    /**
     * Add item to collection
     *
     * @param  array|SpecificationRecord
     * @return fluent interface
     */
    public function addRecord($record)
    {
        if (!is_array($record) && !$record instanceof SpecificationRecord) {
            throw new SpecificationException('record needs to be either an array or instance of ' . __NAMESPACE__ . '\\Specification\\Record');
        }

        if (is_array($record)) {
            $record = new SpecificationRecord($record);
        }

        $name = $record->getName();
        if (!$name || empty($name)) {
            throw new SpecificationException('record name cannot be empty');
        }

        $this->collection[$name] = $record;
        return $this;
    }
}
