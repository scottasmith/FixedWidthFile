<?php
namespace FixedWidthFile\Collection;

use FixedWidthFile\Specification\Field as FieldSpecification;

class Field extends CollectionBase
{
    /**
     * Add item to collection
     *
     * @param  array|FieldSpecification
     * @return fluent interface
     */
    public function addField($field)
    {
        if (!is_array($field) && !$field instanceof FieldSpecification) {
            throw new SpecificationException('field needs to be either an array or instance of ' . __NAMESPACE__ . '\\Collection\\Field');
        }

        if (is_array($field)) {
            $field = new FieldSpecification($field);
        }

        $name = $field->getName();
        if (!$name || empty($name)) {
            throw new SpecificationException('field name cannot be empty');
        }

        $this->collection[$name] = $field;
        return $this;
    }

    /**
     * Sort collection by the position
     */
    public function sortFields()
    {
        // Sort the collection by position
        usort($this->collection, function($a, $b) {
            if ($a->getPosition() == $b->getPosition()) {
                return 0;
            }

            return ($a->getPosition() > $b->getPosition()) ? 1 : -1;
        });
    }

    /**
     * Get fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->collection;
    }
}
