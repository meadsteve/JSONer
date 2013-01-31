JSONer
======

Small utility class to help out with converting PHP objects to json.

Example Usage
=========

Basic usage is very straight forward:

```php
$jsonBuilder = new \MeadSteve\JSONer\JSONer();

$dataToOutput = array(
  'id'               => "y76",
  'requestedData'	 => $ComplexObject
);

$outputString = $jsonBuilder->convertToJSON($dataToOutput);
```

This assumes that you want to use php's default behaviour to encode the ComplexObject. If you wanted a bit more control then ideally you would implement the JsonSerializable in the class. However If this isn't an option you can provide handler functions to the JSONer object: 
```php
$jsonBuilder->registerSerializeFunction('ComplexObject', function($Object) {
  $moreSimpleObject = new stdClass();
  $moreSimpleObject->propertyOne = $Object->getPropertyOne();
  return $moreSimpleObject;
});
```

