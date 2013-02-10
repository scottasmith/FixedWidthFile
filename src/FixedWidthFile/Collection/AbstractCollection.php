<?php
namespace FixedWidthFile\Collection;

use FixedWidthFile\Collection\SpecificationBase;

abstract class AbstractCollection
  implements \Iterator, \Countable
{
    // @var array
    protected $collection = array();

    /**
     * warning - This resets the iterator on the collection array
     *
     * @param string
     * @return SpecificationBase|NULL
     * @throws Exception
     */
    public function findItemByName($nameToFind)
    {
        if (empty($nameToFind)) {
            throw new Exception('nameToFind is an empty string');
        }

        foreach ($this->collection as $itemName => $itemObject) {
            if($this->isItemNameMatch($itemName, $nameToFind))
            {
                return $itemObject;
            }
        }

        return;
    }

    /**
     * @param string
     * @param string
     * @return boolean
     */
    public function isItemNameMatch($itemName, $nameToFind)
    {
        $nameLength = strlen($itemName);

        if (substr($nameToFind, 0, $nameLength) == $itemName) {
            return true;
        }
    }

    /**
     * @param string
     * @return boolean
     */
    public function removeItemByName($name)
    {
        if (array_key_exists($name, $this->collection)) {
            unset($this->collection[$name]);
            return true;
        }
    }

    /**
     * @return array
     */
    public function getCollectionArray()
    {
        return $this->collection;
    }

    /**
     * @return Field
     */
    public function current()
    {
        return current($this->collection);
    }

    public function key()
    {
        return key($this->collection);
    }

    public function next()
    {
        return next($this->collection);
    }

    public function rewind()
    {
        return reset($this->collection);
    }

    public function valid()
    {
        $key = key($this->collection);
        return isset($this->collection[$key]);
    }

    public function count()
    {
        return count($this->collection);
    }
}
