<?php
namespace FixedWidthFile\Collection;

use FixedWidthFile\Collection\SpecificationBase;

abstract class CollectionBase
  implements \Iterator, \Countable
{
    /**
     * Collection array
     * @var array
     */
    protected $collection = array();

    /**
     * Find item
     *  warning - This resets the iterator on the collection array
     *
     * @param string $data
     * @return SpecificationBase|NULL
     */
    public function find($data)
    {
        if (empty($data)) {
            return;
        }

        foreach ($this->collection as $itemName => $itemObject) {
            $nameLength = strlen($itemName);

            if (substr($data, 0, $nameLength) == $itemName) {
                return $itemObject;
            }
        }

        return;
    }

    /**
     * Remove item from array
     *
     * @param  string name
     * @return fluent interface
     */
    public function remove($name)
    {
        if (array_key_exists($name, $this->collection)) {
            unset($this->collection[$name]);
        }

        return $this;
    }

    /**
     * Return Iterator Value
     *
     * @return Field
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Return Iterator Key
     *
     * @return string
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * Next Iterator
     */
    public function next()
    {
        return next($this->collection);
    }

    /**
     * Next Iterator
     */
    public function rewind()
    {
        return reset($this->collection);
    }

    /**
     * Is Iterator valid
     *
     * @return boolean
     */
    public function valid()
    {
        $key = key($this->collection);
        return isset($this->collection[$key]);
    }

    /**
     * Return count
     *
     * @return integer
     */
    public function count()
    {
        return count($this->collection);
    }
}
