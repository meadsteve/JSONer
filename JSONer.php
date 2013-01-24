<?php
namespace MeadSteve\JSONer;

class JSONer {

	protected $serializeFunctions = array();

	/**
	 * Stores the default argument that should be passed as the 2nd param to
	 * json_encode.
	 *
	 * @var int $defaultEncodeArgs
	 */
	protected $defaultEncodeArgs;


	public function __construct($defaultEncodeArgs = JSON_FORCE_OBJECT) {
		$this->defaultEncodeArgs = $defaultEncodeArgs;
	}

	/**
	 * @param mixed $thing The item that needs converting to JSON
	 * @param int $encodeArgs the 2nd argument passed to json_encode
	 * @return string A json representation of the passed in argument
	 */
	public function convertToJSON($thing, $encodeArgs = null) {
		if (is_object($thing)) {
			$processedThing = $this->processObject($thing);
		}
		else if (is_array($thing)) {
			$processedThing = $this->processArray($thing);
		}
		else {
			$processedThing = $thing;
		}
		$encodeArgs = ($encodeArgs !== null) ? $encodeArgs : $this->defaultEncodeArgs;
		return json_encode($processedThing, $encodeArgs);
	}

	/**
	 * Registers a function that will serialize the given class in such a way that
	 * it can be processed by json_encode.
	 *
	 * @param $className
	 * @param $function Callback taking one argument: the object to serialize
	 * @return JSONer so that the object can be fluent
	 * @throws \InvalidArgumentException
	 */
	public function registerSerializeFunction($className, callable $function) {
		if (!is_string($className))
			throw new \InvalidArgumentException("className must be a string");

		$this->serializeFunctions[strtolower($className)] = $function;

		return $this;
	}

	/**
	 * Converts each element in the passed in array to it's jsonserializable
	 * representation using $this->convertToJSON
	 *
	 * @param array $arrayToProcess
	 * @return array
	 */
	protected  function processArray(array $arrayToProcess) {
		foreach($arrayToProcess as $key => $item) {
			$arrayToProcess[$key] = $this->convertToJSON($item);
		}

		return $arrayToProcess;
	}

	/**
	 * Converts the given object to a form understandable by json_encode by one of
	 * two methods:
	 *   Calling a function registered by registerSerializeFunction()
	 *   Calling jsonSerialize() on the object if it implements JsonSerializable
	 * If neither of these is possible the unaltered object will be returned
	 *
	 * @param \stdClass $objectToProcess
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	protected  function processObject($objectToProcess) {
		if (!is_object($objectToProcess))
			throw new \InvalidArgumentException("objectToProcess should be an object");

	// IN PHP5.4 and above a native interface exists so check for this.
		$implementsNativeJson = false;
		if(class_exists('\JsonSerializable')) {
			$implementsNativeJson = ($objectToProcess instanceof \JsonSerializable);
		}

		if ($this->isSeriailizeFunctionRegistered($objectToProcess)) {
			return $this->seriailizeObject($objectToProcess);
		}
		else if($implementsNativeJson ||$objectToProcess instanceof JsonSerializable) {
			return $objectToProcess->jsonSerialize();
		}
		else {
			return $objectToProcess;
		}
	}

	/**
	 * Checks if a jsonserialize callback has been registered for a given object.
	 * @param \stdClass $object
	 * @return bool
	 */
	protected function isSeriailizeFunctionRegistered(\stdClass $object) {
		$key = strtolower(get_class($object));
		return array_key_exists($key, $this->serializeFunctions);
	}

	/**
	 * Returns the result of the registered callback for the specified object.
	 * @param \stdClass $object
	 * @return mixed
	 * @throws \Exception
	 */
	protected function seriailizeObject(\stdClass $object) {
		$serializeFunction
			= $this->serializeFunctions[strtolower(get_class($object))];
		if (is_callable($serializeFunction)) {
			return $serializeFunction($object);
		}
		else {
			// TODO: throw a meaningful exception
			throw new \Exception();
		}
	}
}
