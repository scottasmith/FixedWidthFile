<?php
namespace FixedWidthFile\Specification\Builder;

use FixedWidthFile\Collection\Record as RecordCollection;

abstract class AbstractBuilder implements BuilderInterface
{
    // @var RecordCollection
    protected $recordCollection;

    public function __construct()
    {
        $this->recordCollection = new RecordCollection;
    }

    public function getRecordCollection()
    {
        return $this->recordCollection;
    }

    /**
     * @param mixed
     * @param string
     */
    abstract protected function getValue($source, $key);
}
