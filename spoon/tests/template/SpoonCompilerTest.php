<?php

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

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

		// fetch the content from the template
		$this->assertEquals(
			'value',
			$this->tpl->getContent($this->getTemplatePath('variable.tpl'))
		);
	}

	function testParseArrays()
	{
		$this->tpl->assign(
			'array',
			array('name' => 'Array name')
		);

		// fetch the content from the template
		$this->assertEquals(
			'Array name',
			$this->tpl->getContent($this->getTemplatePath('array.tpl'))
		);
	}

	function testParseObjects()
	{
		// add an object
		$object = new Object();
		$object->setName('Object name');
		$this->tpl->assign('object', $object);

		// fetch the content from the template
		$this->assertEquals(
			'Object name',
			$this->tpl->getContent($this->getTemplatePath('object.tpl'))
		);
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

		// fetch the content from the template
		$this->assertEquals(
			'Array name',
			$this->tpl->getContent($this->getTemplatePath('nested_array.tpl'))
		);
	}

	function testParseNestedObjects()
	{
		$nestedObject = new Object();
		$nestedObject->setName('Object name');

		$object = new Object();
		$object->setNestedObject($nestedObject);

		$this->tpl->assign('object', $object);

		// fetch the content from the template
		$this->assertEquals(
			'Object name',
			$this->tpl->getContent($this->getTemplatePath('nested_object.tpl'))
		);
	}

	function testParseArrayInObject()
	{
		$nestedArray = array('name' => 'Inside an object');

		$object = new Object();
		$object->setArray($nestedArray);

		$this->tpl->assign('object', $object);

		// fetch the content from the template
		$this->assertEquals(
			'Inside an object',
			$this->tpl->getContent(
				$this->getTemplatePath('array_in_object.tpl')
			)
		);
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

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$this->tpl->getContent(
				$this->getTemplatePath('iteration_over_array.tpl')
			)
		);
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

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$this->tpl->getContent(
				$this->getTemplatePath('iteration_over_nested_array.tpl')
			)
		);
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

		$this->tpl->assign(
			'object',
			$object
		);

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$this->tpl->getContent(
				$this->getTemplatePath('iteration_over_array_in_object.tpl')
			)
		);
	}

	function testIterationOverArrayOfObjects()
	{
		$object1 = new Object();
		$object1->setName('Foo');

		$object2 = new Object();
		$object2->setName('Bar');

		$this->tpl->assign('array', array($object1, $object2));

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$this->tpl->getContent(
				$this->getTemplatePath('iteration_over_array_of_objects.tpl')
			)
		);
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

		// fetch the content from the template
		$this->assertEquals(
			'FooBar',
			$this->tpl->getContent(
				$this->getTemplatePath('iteration_over_collection.tpl')
			)
		);
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

		// fetch the content from the template
		$this->assertEquals(
			'Object1Object2',
			$this->tpl->getContent(
				$this->getTemplatePath('iteration_over_collection_of_objects.tpl')
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
