FixedWidthFile
=
Version 1.0 Created by Scott Smith

Introduction
-

Enables quick and easy use of fixed width files.
You give it a specification for a file. This holds the types or records/lines the file has.
For each line you then add the field, field type, position on the line, etc.
There are currently two builders to use to build the file specification:

* Xml
* Array

You can also extend the AbstractBuilder to make your own if you wish. This can be in code or
from a source of your choice

Features / Goals
-

* Separate code from file fixed width file structure
* Ease of use
* Fast to use

Installation
-

### Setup

 Clone this project into your `./vendors/` directory and your done

### Expected specification structure

Each record/line contains identifying parameters:

* Name
* Description
* Priority
* Key Field - Name of a field in this record

Each field in the record contains parameters to control placement:

* Name
* Position - Position on line
* Length
* Format
* Validation - Regex
* Default Value - Can be omitted
* Mandatory - Can be omitted (default no)

### Example of array specification for one line and two fields

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
            )
        )
    );

### Sample XML file

    <?xml version="1.0" encoding="UTF-8"?>
    <file name="TestFile" description="Test File For Builder">
     <line name="LINESPEC1" description="TestDescriptionSpecification1" priority="1"   keyField="SomeKeyField">
      <field name="SomeField1" pos="0" length="5" format="String" defaultValue="DefVal" validation="[[:alnum:]]" mandatory=""/>
      <field name="SomeKeyField" pos="5" length="3" format="Integer" defaultValue="" validation="[[:digit:]]" mandatory=""/>
     </line>
    </file>

## Example script using the above xml file

    <?php
    require_once __DIR__ . '/../vendor/autoload.php';

    use FixedWidthFile\Specification\Builder\Factory as BuilderFactory;
    use FixedWidthFile\EncodeFile;

    // Data to encode into fixed file
    $testRecords = array(
        array(
            'identifier' => 'LINESPEC1', // Line name in specification
            'fields'     => array(
                'SomeKeyField' => 1,      // Field 2
                'SomeField1'   => 'TST1', // Field 1
            )
        )
    );

    try {
        $builder = BuilderFactory::createXmlBuilder('TestFile.xml');
    }
    catch(Exception $ex) {
        die('Error: ' . $ex->getMessage() . "\n\n\n");
    }

    $recordCollection = $builder->getRecordCollection();

    $encode = new EncodeFile;
    $encode->setRecordCollection($recordCollection);
    $lineStringArray = $encode->encode($testRecords);

    echo implode("\n", $lineStringArray);
