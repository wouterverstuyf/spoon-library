<?php

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';
require_once 'Collection.php';
require_once 'Object.php';

class SpoonTemplateCompilerTest extends PHPUnit_Framework_TestCase
{
	protected $tpl;

	function setUp()
	{
		// create a spoon template
		$this->tpl = new SpoonTemplate();
		$this->tpl->setForceCompile(true);
		$this->tpl->setCompileDirectory(dirname(__FILE__) . '/cache');
	}

	function testParseVariables()
	{
		$this->tpl->assign('variable', 'value');
		$this->runTests('value', 'variable.tpl');
	}

	function testParseArrays()
	{
		$this->tpl->assign(
			'array',
			array('name' => 'Array name')
		);
		$this->runTests('Array name', 'array.tpl');
	}

	function testParseObjects()
	{
		// add an object
		$object = new Object();
		$object->setName('Object name');
		$this->tpl->assign('object', $object);
		$this->runTests('Object name', 'object.tpl');
	}

	function testParseNestedArrays()
	{
		$this->tpl->assign(
			'array',
			array(
				'inner_array' => array(
					'name' => 'Array name'
				)
			)
		);
		$this->runTests('Array name', 'nested_array.tpl');
	}

	function testParseNestedObjects()
	{
		$nestedObject = new Object();
		$nestedObject->setName('Object name');

		$object = new Object();
		$object->setNestedObject($nestedObject);

		$this->tpl->assign('object', $object);
		$this->runTests('Object name', 'nested_object.tpl');
	}

	function testParseArrayInObject()
	{
		$nestedArray = array('name' => 'Inside an object');

		$object = new Object();
		$object->setArray($nestedArray);

		$this->tpl->assign('object', $object);
		$this->runTests('Inside an object', 'array_in_object.tpl');
	}

	function testIterationOverArray()
	{
		$this->tpl->assign(
			'array',
			array(
				array('name' => 'Foo'),
				array('name' => 'Bar'),
			)
		);
		$this->runTests('FooBar', 'iteration_over_array.tpl');
	}

	function testIterationOverNestedArray()
	{
		$this->tpl->assign(
			'array',
			array(
				'nested_array' => array(
					array('name' => 'Foo'),
					array('name' => 'Bar'),
				)
			)
		);
		$this->runTests('FooBar', 'iteration_over_nested_array.tpl');
	}

	function testIterationOverArrayInObject()
	{
		$object = new Object();
		$object->setArray(
			array(
				array('name' => 'Foo'),
				array('name' => 'Bar'),
			)
		);

		$this->tpl->assign('object', $object);
		$this->runTests('FooBar', 'iteration_over_array_in_object.tpl');
	}

	function testIterationOverArrayOfObjects()
	{
		$object1 = new Object();
		$object1->setName('Foo');

		$object2 = new Object();
		$object2->setName('Bar');

		$this->tpl->assign('array', array($object1, $object2));
		$this->runTests('FooBar', 'iteration_over_array_of_objects.tpl');
	}

	function testIterationOverCollection()
	{
		$collection = new Collection(
			array(
				array('name' => 'Foo'),
				array('name' => 'Bar'),
			)
		);

		$this->tpl->assign('collection', $collection);
		$this->runTests('FooBar', 'iteration_over_collection.tpl');
	}

	function testIterationOverCollectionOfObjects()
	{
		$object1 = new Object();
		$object1->setName('Object1');

		$object2 = new Object();
		$object2->setName('Object2');

		$collection = new Collection(
			array($object1, $object2)
		);

		$this->tpl->assign('collection', $collection);
		$this->runTests('Object1Object2', 'iteration_over_collection_of_objects.tpl');
	}

	function testCycle()
	{
		$this->tpl->assign(
			'array',
			array(
				array('number' => 'One'),
				array('number' => 'Two'),
				array('number' => 'Three'),
			)
		);
		$this->runTests('One: Odd, Two: Even, Three: Odd, ', 'cycle.tpl');
	}

	function testCycleOverArrayInObject()
	{
		$array = array(
			array('number' => '1'),
			array('number' => '2'),
			array('number' => '3'),
		);
		$object = new Object();
		$object->setArray($array);
		$this->tpl->assign('object', $array);
		$this->runTests('1: Odd, 2: Even, 3: Odd, ', 'cycle_over_array_in_object.tpl');
	}

	function testCycleOverCollection()
	{
		$array = array(
			array('number' => '0'),
			array('number' => '1'),
			array('number' => '2'),
		);
		$collection = new Collection($array);
		$this->tpl->assign('collection', $collection);
		$this->runTests('0: Even, 1: Odd, 2: Even, ', 'cycle_over_collection.tpl');
	}

	function testFirstAndLast()
	{
		$this->tpl->assign(
			'array',
			array(
				array('number' => 'One'),
				array('number' => 'Two'),
				array('number' => 'Three'),
			)
		);
		$this->runTests('First: One, Last: Three', 'first_last.tpl');
	}

	function testFirstAndLastForArrayInObject()
	{
		$array = array(
			array('number' => '1'),
			array('number' => '2'),
			array('number' => '3'),
		);
		$object = new Object();
		$object->setArray($array);
		$this->tpl->assign('object', $array);
		$this->runTests('First: 1, Last: 3', 'first_last_array_in_object.tpl');
	}

	function testFirstAndLastForCollection()
	{
		$array = array(
			array('number' => '0'),
			array('number' => '1'),
			array('number' => '2'),
		);
		$collection = new Collection($array);
		$this->tpl->assign('object', $collection);
		$this->runTests('First: 0, Last: 2', 'first_last_array_in_object.tpl');
	}

	function testOption()
	{
		// boolean true
		$this->tpl->assign('test', true);
		$this->runTests('Yes', 'option.tpl');

		// integer that isn't zero
		$this->tpl->assign('test', 1);
		$this->runTests('Yes', 'option.tpl');

		// string that isn't empty
		$this->tpl->assign('test', 'tralala');
		$this->runTests('Yes', 'option.tpl');

		// array with content
		$this->tpl->assign('test', array('tralala'));
		$this->runTests('Yes', 'option.tpl');

		// boolean false
		$this->tpl->assign('test', false);
		$this->runTests('No', 'option.tpl');

		// integer 0
		$this->tpl->assign('test', 0);
		$this->runTests('No', 'option.tpl');

		// empty string
		$this->tpl->assign('test', '');
		$this->runTests('No', 'option.tpl');

		// empty array
		$this->tpl->assign('test', array());
		$this->runTests('No', 'option.tpl');
	}

	protected function runTests($output, $template)
	{
		Spoon::setDebug(true);
		$this->assertEquals(
			$output, $this->tpl->getContent($this->getTemplatePath($template))
		);
		Spoon::setDebug(false);
		$this->assertEquals(
			$output, $this->tpl->getContent($this->getTemplatePath($template))
		);
	}

	protected function getTemplatePath($templateName)
	{
		return dirname(__FILE__) . '/templates/' . $templateName;
	}
}
