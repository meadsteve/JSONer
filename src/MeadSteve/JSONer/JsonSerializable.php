<?php
namespace MeadSteve\JSONer;

/**
 * @package    JSONer
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

interface JsonSerializable {
	/**
	 * This function should return an object, array or primitive that
	 * represents the implementing object. The returned value should be
	 * encodable by json_encode.
	 *
	 * @return mixed
	 */
	public function jsonSerialize();
}
