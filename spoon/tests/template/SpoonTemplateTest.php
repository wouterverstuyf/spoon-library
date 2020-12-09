<?php

use PHPUnit\Framework\TestCase;

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonTemplateTest extends TestCase
{
	public function testMain()
	{
		$tpl = new SpoonTemplate();
	}

	public function testGetAssignedValue()
	{
		$tpl = new SpoonTemplate();
		$tpl->assign('name', 'value');
		$tpl->assign('list', array('name' => 'Erik Bauffman'));
		$this->assertEquals('value', $tpl->getAssignedValue('name'));
		$this->assertEquals(array('name' => 'Erik Bauffman'), $tpl->getAssignedValue('list'));
		$this->assertEquals(null, $tpl->getAssignedValue('wtf-this-is-super-cool'));
	}
}
