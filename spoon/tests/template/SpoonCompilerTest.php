<?php

date_default_timezone_set('Europe/Brussels');

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
}

/**
 * POPO to test spoon template with
 */
class Object
{
	protected $name;
	protected $nestedObject;

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
}
