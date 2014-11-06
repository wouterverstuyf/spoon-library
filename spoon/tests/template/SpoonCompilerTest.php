<?php

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonTemplateCompilerTest extends PHPUnit_Framework_TestCase
{
	function testParseVariables()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$tpl->assign('variable', 'value');

		// fetch the content from the template
		$this->assertEquals(
			'value',
			$tpl->getContent(dirname(__FILE__) . '/templates/variable.tpl')
		);
	}

	function testParseArrays()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$tpl->assign(
			'array',
			array('name' => 'Array name')
		);

		// fetch the content from the template
		$this->assertEquals(
			'Array name',
			$tpl->getContent(dirname(__FILE__) . '/templates/array.tpl')
		);
	}

	function testParseObjects()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		// add an object
		$object = new Object();
		$object->setName('Object name');
		$tpl->assign('object', $object);

		// fetch the content from the template
		$this->assertEquals(
			'Object name',
			$tpl->getContent(dirname(__FILE__) . '/templates/object.tpl')
		);
	}

	function testParseNestedArrays()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$tpl->assign(
			'array',
			array(
				'inner_array' => array(
					'name' => 'Array name'
				)
			)
		);

		// fetch the content from the template
		$this->assertEquals(
			'Array name',
			$tpl->getContent(dirname(__FILE__) . '/templates/nested_array.tpl')
		);
	}

	function testParseNestedObjects()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$nestedObject = new Object();
		$nestedObject->setName('Object name');

		$object = new Object();
		$object->setNestedObject($nestedObject);

		$tpl->assign('object', $object);

		// fetch the content from the template
		$this->assertEquals(
			'Object name',
			$tpl->getContent(dirname(__FILE__) . '/templates/nested_object.tpl')
		);
	}

	function testParseArrayInObject()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$nestedArray = array('name' => 'Inside an object');

		$object = new Object();
		$object->setArray($nestedArray);

		$tpl->assign('object', $object);

		// fetch the content from the template
		$this->assertEquals(
			'Inside an object',
			$tpl->getContent(dirname(__FILE__) . '/templates/array_in_object.tpl')
		);
	}

	function testIterationOverArray()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$tpl->assign(
			'array',
			array(
				array('name' => 'Foo'),
				array('name' => 'Bar'),
			)
		);

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$tpl->getContent(dirname(__FILE__) . '/templates/iteration_over_array.tpl')
		);
	}

	function testIterationOverNestedArray()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$tpl->assign(
			'array',
			array(
				'nested_array' => array(
					array('name' => 'Foo'),
					array('name' => 'Bar'),
				)
			)
		);

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$tpl->getContent(dirname(__FILE__) . '/templates/iteration_over_nested_array.tpl')
		);
	}

	function testIterationOverArrayInObject()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$object = new Object();
		$object->setArray(
			array(
				array('name' => 'Foo'),
				array('name' => 'Bar'),
			)
		);

		$tpl->assign(
			'object',
			$object
		);

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$tpl->getContent(dirname(__FILE__) . '/templates/iteration_over_array_in_object.tpl')
		);
	}
}

/**
 * POPO to test spoon template with
 */
class Object
{
	protected $name;
	protected $nestedObject;
	protected $array;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getNestedObject()
	{
		return $this->nestedObject;
	}

	public function setNestedObject($nestedObject)
	{
		$this->nestedObject = $nestedObject;

		return $this;
	}

	public function getArray()
	{
		return $this->array;
	}

	public function setArray(array $array)
	{
		$this->array = $array;

		return $this;
	}
}
