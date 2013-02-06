<?php
namespace FixedWidthFile\Specification\Builder;

class Factory
{
    /**
     * @param array
     */
    public function createArrayBuilder($specificationArray)
    {
        $builder = new ArrayBuilder;

        if (is_array($specificationArray))
        {
            $builder->buildRecordCollectionFromArray($specificationArray);
        }

        return $builder;
    }

    /**
     * @param string
     */
    public function createXmlBuilder($xmlFilename)
    {
        $builder = new XmlBuilder;

        if (file_exists($xmlFilename))
        {
            $builder->buildRecordCollectionFromXmlFile($xmlFilename);
        }

        return $builder;
    }

    /**
     * @param BuilderInterface
     */
    public function createClassBuilder(BuilderInterface $builder)
    {
        $builder->buildRecordCollection();
        return $builder;
    }
}
