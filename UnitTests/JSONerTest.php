<?php
namespace MeadSteve\JSONer;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-24 at 17:51:39.
 */


class JSONerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JSONer
     */
    protected $testedJSONer;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->testedJSONer = new JSONer();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers MeadSteve\JASONer\JSONer::convertToJSON
     */
    public function testConvertToJSON_WithInt()
    {
		$ExpectedResult = "3";
        $ActualResult = $this->testedJSONer->convertToJSON(3);

		assertThat($ActualResult, is($ExpectedResult));
    }

	/**
     * @covers MeadSteve\JASONer\JSONer::convertToJSON
     */
    public function testConvertToJSON_WithString()
    {
		$Input = "I'm a test string";
		$ExpectedResult = "\"I'm a test string\"";

        $ActualResult = $this->testedJSONer->convertToJSON($Input);

		assertThat($ActualResult, is($ExpectedResult));
    }

	/**
     * @covers MeadSteve\JASONer\JSONer::convertToJSON
     */
    public function testConvertToJSON_WithArray()
    {
		$Input = array("One" => 1, "Two" => 2, "One and Two" => 3);
		$ExpectedResult = "{\"One\":\"1\",\"Two\":\"2\",\"One and Two\":\"3\"}";

        $ActualResult = $this->testedJSONer->convertToJSON($Input);

		assertThat($ActualResult, is($ExpectedResult));
    }

    /**
     * @covers MeadSteve\JASONer\JSONer::registerSerializeFunction
	 * @covers MeadSteve\JASONer\JSONer::convertToJSON
     */
    public function testRegisterSerializeFunction()
    {
		$Serializer = function($object) {
			$outputObject = new \stdClass();
			$outputObject->keptProperty = $object->keptProperty;
			return $outputObject;
		};

		$this->testedJSONer->registerSerializeFunction('stdclass', $Serializer);

        $input = new \stdClass();
		$input->keptProperty = "Hello";
		$input->lostProperty = "Goodbye";

		$ExpectedResult = "{\"keptProperty\":\"Hello\"}";

		$ActualResult = $this->testedJSONer->convertToJSON($input);

		assertThat($ActualResult, is($ExpectedResult));
    }
}