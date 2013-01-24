<?php

use MeadSteve\JSONer\JSONer;
use MeadSteve\JSONer\ExtendedJsonSerializable;

class TestExtendedSerializableObject implements ExtendedJsonSerializable{

	/**
	 * @param JSONer $encoder
	 * @return mixed|stdClass
	 */
	public function jsonSerialize(JSONer $encoder) {
		$encodedObject = new \stdClass();
		$encodedObject->keptProperty = $encoder->getPreparedData($this->keptProperty);
		return $encodedObject;
	}

	public $keptProperty;
	public $lostProperty;
}
