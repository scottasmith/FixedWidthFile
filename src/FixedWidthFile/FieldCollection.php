<?php
namespace FixedWidthFile;

use FixedWidthFile\Specification\Field;

class FieldCollection
  implements \Iterator, \Countable
{
    /**
     * Field array
     * @var array
     */
    protected $fields = array();

    /**
     * Add field specification to record
     *
     * @param  array|Field
     * @return fluent interface
     */
    public function addField($field)
    {
        if (!is_array($field) && !$field instanceof Field) {
            throw new SpecificationException('Field needs to be either an array or instance of ' . __NAMESPACE__ . '\\Field');
        }

        if (is_array($field)) {
            $field = new Field($field);
        }

        $name = $field->getName();
        if (!$name || empty($name)) {
            throw new SpecificationException('field name cannot be empty');
        }

        $this->fields[$name] = $field;
        return $this;
    }

    /**
     * Remove field specification from the record
     *
     * @param  string field name
     * @return fluent interface
     */
    public function removeField($name)
    {
        if (array_key_exists($name, $this->fields)) {
            unset($this->fields[$name]);
        }

        return $this;
    }

    /**
     * Get fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Sort fields by the position
     */
    public function sortFields()
    {
        // Sort the fields by position
        usort($this->fields, function($a, $b) {
            if ($a->getPosition() == $b->getPosition()) {
                return 0;
            }

            return ($a->getPosition() > $b->getPosition()) ? 1 : -1;
        });
    }

    /**
     * Return Iterator Value
     *
     * @return Field
     */
    public function current()
    {
        return current($this->fields);
    }

    /**
     * Return Iterator Key
     *
     * @return string
     */
    public function key()
    {
        return key($this->fields);
    }

    /**
     * Next Iterator
     */
    public function next()
    {
        return next($this->fields);
    }

    /**
     * Next Iterator
     */
    public function rewind()
    {
        return reset($this->fields);
    }

    /**
     * Is Iterator valid
     *
     * @return boolean
     */
    public function valid()
    {
        $key = key($this->fields);
        return isset($this->fields[$key]);
    }

    /**
     * Return fields count
     *
     * @return integer
     */
    public function count()
    {
        return count($this->fields);
    }
}