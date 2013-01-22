<?php
namespace FixedWidthFile\SpecificationBuilder;

use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Collection\Field as FieldCollection;

class XmlBuilder implements BuilderInterface
{
    // @var RecordCollection
    protected $recordCollection;

    // @var \DomDocument
    protected $xmlDom;

    public function __construct()
    {
        $this->recordCollection = new RecordCollection;
    }

    public function getRecordCollection()
    {
        return $this->recordCollection;
    }

    public function buildRecordCollectionFromXmlFile($xmlFilename)
    {
        if (!file_exists($xmlFilename))
        {
            return;
        }

        $this->xmlDom = $this->getDomDocument($xmlFilename);
        $fileNode = $this->getFileNode();
        if (!$fileNode)
        {
            return;
        }

        $recordNodeList = $this->getRecordNodeList($fileNode);

        $this->buildRecordCollectionFromNodeList($recordNodeList);
    }

    protected function getDomDocument($xmlFilename)
    {
        $xmlDom = new \DomDocument('1.0', 'UTF-8');
        $xmlDom->load($xmlFilename);

        return $xmlDom;
    }

    /**
     * @return \DOMNode|NULL
     */
    protected function getFileNode()
    {
        $nodes = $this->xmlDom->getElementsByTagName('file');
        if ($nodes && $nodes->length > 0)
        {
            return $nodes->item(0);
        }

        return;
    }

    /**
     * @param \DOMNode
     * @return \DOMNodeList
     */
    protected function getRecordNodeList(\DOMNode $fileNode)
    {
        $nodes = $fileNode->getElementsByTagName('line');

        return $nodes ? $nodes : new DOMNodeList;
    }

    /**
     * @param \DOMNodeList
     */
    protected function buildRecordCollectionFromNodeList(\DOMNodeList $recordNodeList)
    {
        foreach ($recordNodeList as $recordNode)
        {
            $recordSpecification = $this->getRecordSpecificationFromNode($recordNode);
            $this->recordCollection->addRecord($recordSpecification);
        }
    }

    /**
     * @param \DOMNode $recordNode
     * @return RecordSpecification
     */
    protected function getRecordSpecificationFromNode(\DOMNode $recordNode)
    {
        $fieldCollection = $this->getFieldCollectionFromNode($recordNode->childNodes);

        $recordSpecification = new RecordSpecification;
        $recordSpecification->setName($recordNode->getAttribute('name'));
        $recordSpecification->setDescription($recordNode->getAttribute('description'));
        $recordSpecification->setPriority($recordNode->getAttribute('priority'));
        $recordSpecification->setKeyField($recordNode->getAttribute('keyField'));
        $recordSpecification->setFieldCollection($fieldCollection);

        return $recordSpecification;
    }

    /**
     * @param DOMNodeList
     * @return FieldCollection
     */
    protected function getFieldCollectionFromNode($fieldNodeList)
    {
        $fieldCollection = new FieldCollection;

        foreach($fieldNodeList as $fieldNode)
        {
            $fieldSpecification = $this->getFieldSpecificationFromNode($fieldNode);

            if ($fieldSpecification)
            {
                $fieldCollection->addField($fieldSpecification);
            }
        }

        return $fieldCollection;
    }

    /**
     * @param DOMNodeList
     * @return FieldSpecification|NULL
     */
    protected function getFieldSpecificationFromNode($fieldNode)
    {
        if ($fieldNode->nodeName == 'field')
        {
            $name = $fieldNode->getAttribute('name');

            $fieldSpecification = new FieldSpecification;

            $fieldSpecification->setName($name);
            $fieldSpecification->setPosition($fieldNode->getAttribute('pos'));
            $fieldSpecification->setLength($fieldNode->getAttribute('length'));
            $fieldSpecification->setFormat($fieldNode->getAttribute('format'));
            $fieldSpecification->setDefaultValue($fieldNode->getAttribute('defaultValue'));
            $fieldSpecification->setValidation($fieldNode->getAttribute('validation'));
            $fieldSpecification->setMandatory($fieldNode->getAttribute('mandatory') ? true : false);

            return $fieldSpecification;
        }

        return;
    }
}
