<?php
namespace FixedWidthFile\SpecificationBuilder;

class BuilderFactory
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
}
