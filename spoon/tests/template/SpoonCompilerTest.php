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
			$tpl->getContent($this->getTemplatePath('variable.tpl'))
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
			$tpl->getContent($this->getTemplatePath('array.tpl'))
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
			$tpl->getContent($this->getTemplatePath('object.tpl'))
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
			$tpl->getContent($this->getTemplatePath('nested_array.tpl'))
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
			$tpl->getContent($this->getTemplatePath('nested_object.tpl'))
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
			$tpl->getContent(
				$this->getTemplatePath('array_in_object.tpl')
			)
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
			$tpl->getContent(
				$this->getTemplatePath('iteration_over_array.tpl')
			)
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
			$tpl->getContent(
				$this->getTemplatePath('iteration_over_nested_array.tpl')
			)
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
			$tpl->getContent(
				$this->getTemplatePath('iteration_over_array_in_object.tpl')
			)
		);
	}

	function testIterationOverArrayOfObjects()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$object1 = new Object();
		$object1->setName('Foo');

		$object2 = new Object();
		$object2->setName('Bar');

		$tpl->assign('array', array($object1, $object2));

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$tpl->getContent(
				$this->getTemplatePath('iteration_over_array_of_objects.tpl')
			)
		);
	}

	function testIterationOverCollection()
	{
		// create a spoon template
		$tpl = new SpoonTemplate();
		$tpl->setForceCompile(true);
		$tpl->setCompileDirectory(dirname(__FILE__) . '/cache');

		$collection = new Collection(
			array(
				array('name' => 'Foo'),
				array('name' => 'Bar'),
			)
		);

		$tpl->assign('collection', $collection);

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$tpl->getContent(
				$this->getTemplatePath('iteration_over_collection.tpl')
			)
		);
	}

	protected function getTemplatePath($templateName)
	{
		return dirname(__FILE__) . '/templates/' . $templateName;
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

/**
 * An iteratable class (like doctrine's persistentCollection)
 */
class Collection implements Countable, IteratorAggregate, ArrayAccess
{
	private $array = array();

	public function count()
	{
		return count($this->array);
	}

	public function __construct(array $array)
	{
		$this->array = $array;
	}

	public function getIterator()
	{
		return new ArrayIterator($this->array);
	}

	public function offsetExists($offset)
	{
		isset($this->array[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->array[$offset]) ? $this->array[$offset] : null;
	}

	public function offsetSet($offset, $value)
	{
		if(is_null($offset))
		{
			$this->array[] = $value;
		}
		else
		{
			$this->array[$offset] = $value;
		}
	}

	public function offsetUnset($offset)
	{
		unset($this->container[$offset]);
	}
}
