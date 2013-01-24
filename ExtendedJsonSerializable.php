<?php
namespace MeadSteve\JSONer;

interface ExtendedJsonSerializable {
	/**
	 * This function should return an object, array or primitive that
	 * represents the implementing object. The returned value should be
	 *  encodable by json_encode.
	 *
	 * @param JSONer $encoderToUse an instance of JSONer to be used in encoding any
	 *         data within the class.
	 * @return mixed
	 */
	public function jsonSerialize(JSONer $encoderToUse);
}
