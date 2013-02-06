<?php
namespace FixedWidthFile\Specification\Builder;

use FixedWidthFile\Specification\Record as RecordSpecification;
use FixedWidthFile\Specification\Field as FieldSpecification;
use FixedWidthFile\Collection\Record as RecordCollection;
use FixedWidthFile\Collection\Field as FieldCollection;
use FixedWidthFile\Specification\Builder\Exception\Exception;

class XmlBuilder extends AbstractBuilder
{
    // @var \DomDocument
    protected $xmlDom;

    /**
     * @throws ParserException
     */
    public function buildRecordCollectionFromXmlFile($xmlFilename)
    {
        if (!file_exists($xmlFilename)) {
            throw new Exception("Xml file does not exist ($xmlFilename)");
        }

        $this->xmlDom = $this->getDomDocument($xmlFilename);
        $fileNode = $this->getFileNode();

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
        if (!$nodes || $nodes->length == 0) {
            throw new Exception("Cannot find the 'file' element in the Xml file");
        }

        return $nodes->item(0);
    }

    /**
     * @param \DOMNode
     * @return \DOMNodeList
     */
    protected function getRecordNodeList(\DOMNode $fileNode)
    {
        $nodes = $fileNode->getElementsByTagName('line');
        if (!$nodes || $nodes->length == 0) {
            throw new Exception("Cannot find the 'line' element in the Xml file");
        }

        return $nodes;
    }

    /**
     * @param \DOMNodeList
     */
    protected function buildRecordCollectionFromNodeList(\DOMNodeList $recordNodeList)
    {
        foreach ($recordNodeList as $recordNode) {
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
        $name = $this->getValue($recordNode, 'name');

        $recordSpecification = new RecordSpecification;
        $recordSpecification->setName($name);
        $recordSpecification->setRecordDescription($this->getValue($recordNode, 'description'));
        $recordSpecification->setRecordPriority($this->getValue($recordNode, 'priority'));
        $recordSpecification->setRecordKeyField($this->getValue($recordNode, 'keyField'));

        if (!$recordNode->hasChildNodes()) {
            throw new Exception("No fields defined for record $name");
        }

        $fieldCollection = $this->getFieldCollectionFromNode($recordNode->childNodes);
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

        foreach($fieldNodeList as $fieldNode) {
            $fieldSpecification = $this->getFieldSpecificationFromNode($fieldNode);

            if ($fieldSpecification) {
                $fieldCollection->addField($fieldSpecification);
            }
        }

        return $fieldCollection;
    }

    /**
     * @param DOMNode
     * @return FieldSpecification|NULL
     */
    protected function getFieldSpecificationFromNode($fieldNode)
    {
        if ($fieldNode->nodeName == 'field') {
            $name = $this->getValue($fieldNode, 'name');

            $fieldSpecification = new FieldSpecification;

            $fieldSpecification->setName($name);
            $fieldSpecification->setFieldPosition($this->getValue($fieldNode, 'pos'));
            $fieldSpecification->setFieldLength($this->getValue($fieldNode, 'length'));
            $fieldSpecification->setFieldFormat($this->getValue($fieldNode, 'format'));
            $fieldSpecification->setFieldDefaultValue($this->getValue($fieldNode, 'defaultValue', true));
            $fieldSpecification->setFieldValidation($this->getValue($fieldNode, 'validation'));
            $mandatory = $this->getValue($fieldNode, 'mandatory', true);
            $fieldSpecification->setMandatoryField($mandatory ? true : false);

            return $fieldSpecification;
        }

        return;
    }

    /**
     * @param DOMNode
     * @param string
     * @param boolean
     */
    protected function getValue($source, $key, $nullOk = false)
    {
        if (!$source->hasAttribute($key) && !$nullOk) {
            throw new Exception("Cannot find attribute $key");
        }

        return !$source->hasAttribute($key) ? '' : $source->getAttribute($key);
    }
}
