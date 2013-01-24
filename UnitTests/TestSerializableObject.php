<?php

class TestSerializableObject implements \MeadSteve\JSONer\JsonSerializable{

	/**
	 * This function should return an object, array or primitive that
	 * represents the implementing object. The returned value should be
	 * encodable by json_encode.
	 *
	 * @return mixed
	 */
	public function jsonSerialize() {
		$encodedObject = new \stdClass();
		$encodedObject->keptProperty = $this->keptProperty;
		return $encodedObject;
	}

	public $keptProperty;
	public $lostProperty;
}
