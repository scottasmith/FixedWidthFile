<?php
return array(
    array(
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
                'name'       => 'KeyField',
                'position'   => 5,
                'length'     => 3,
                'format'     => 'Integer',
                'validation' => '[[:digit:]]'
            ),
            array(
                'name'       => 'Size',
                'position'   => 8,
                'length'     => 2,
                'format'     => 'Integer',
                'validation' => '[[:digit:]]'
            )
        ),
    ),
    array(
        'recordSpecification' => array(
            'name' => 'LINESPEC2',
            'description' => 'TestDescriptionSpecification2',
            'priority' => 1,
            'keyField' => 'SomeField2'
        ),
        'fields' => array(
            array(
                'name'       => 'SomeField2',
                'position'   => 0,
                'length'     => 5,
                'format'     => 'String',
                'validation' => '[[:alnum:]]',
                'defaultValue' => 'DefVal'
            ),
            array(
                'name'       => 'Size',
                'position'   => 5,
                'length'     => '2',
                'format'     => 'Integer',
                'validation' => '[[:digit:]]'
            )
        ),
    )
);
