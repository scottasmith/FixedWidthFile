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

    static public function getRecordSpecification()
    {
        return array(
            'name' => 'LINESPEC1',
            'description' => 'TestDescriptionSpecification1',
            'priority' => 1,
            'keyField' => 'KeyField'
        );
    }

    static public function getRecordLines()
    {
        return array(
            'recordSpecification' => array(
                'name' => 'LINESPEC1',
                'description' => 'TestDescriptionSpecification1',
                'priority' => 1,
                'keyField' => 'KeyField'
            ),
            'fields' => array(
                array(
                    'name'       => 'SomeField1',
                    'position'   => 0,
                    'length'     => 5,
                    'format'     => 'String',
                    'validation' => '[[:alnum:]]',
                    'defaultValue' => 'DefVal'
                ),
                array(
                    'name'       => 'Size',
                    'position'   => 5,
                    'length'     => 8,
                    'format'     => 'Integer',
                    'validation' => '[[:digit:]]'
                )
            )
        );
    }
}