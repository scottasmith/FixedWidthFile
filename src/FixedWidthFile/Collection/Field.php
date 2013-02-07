<?php
namespace FixedWidthFile\Collection;

use FixedWidthFile\Specification\Field as FieldSpecification;

class Field extends AbstractCollection
{
    /**
     * @param  array|FieldSpecification
     * @return boolean
     */
    public function addField($fieldSpecification)
    {
        if (is_array($fieldSpecification)) {
            $fieldSpecification = new FieldSpecification($fieldSpecification);
        }

        if (!$this->isFieldSpecification($fieldSpecification))
        {
            return;
        }

        $name = $fieldSpecification->getName();
        if (!$name || empty($name)) {
            return;
        }

        $this->collection[$name] = $fieldSpecification;

        return true;
    }

    public function isFieldSpecification($fieldSpecification)
    {
        if (is_array($fieldSpecification) || $fieldSpecification instanceof FieldSpecification) {
             return true;
        }

        return;
    }

    public function sortFields()
    {
        // Sort the collection by position
        usort($this->collection, function($a, $b) {
            if ($a->getFieldPosition() == $b->getFieldPosition()) {
                return 0;
            }

            return ($a->getFieldPosition() > $b->getFieldPosition()) ? 1 : -1;
        });
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->collection;
    }
}
