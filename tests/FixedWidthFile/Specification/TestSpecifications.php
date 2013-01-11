<?php
namespace FixedWidthFile\Specification;

class TestSpecifications
{
    static public function getFieldSpecification()
    {
        return array(
            'name'       => 'RecordIdentifier',
            'position'   => 0,
            'length'     => 5,
            'format'     => 'String',
            'validation' => '[[:alnum:]]',
            'defaultValue' => 'DefVal'
        );
    }

    static public function getFieldSpecifications()
    {
        return array(
            array(
                'name'       => 'RecordIdentifier',
                'position'   => 10,
                'length'     => 5,
                'format'     => 'String',
                'validation' => '[[:alnum:]]',
                'defaultValue' => 'DefVal'
            ),
            array(
                'name'       => 'Size',
                'position'   => 0,
                'length'     => '10',
                'format'     => 'Integer',
                'validation' => '[[:digit:]]'
            )
        );
    }
}