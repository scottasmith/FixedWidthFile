<?php
namespace FixedWidthFile\SpecificationBuilder;

interface BuilderInterface
{
    /**
     * @return RecordCollection
     */
    public function getRecordCollection();
}