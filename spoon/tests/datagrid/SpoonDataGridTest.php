<?php

use PHPUnit\Framework\TestCase;

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonDataGridTest extends TestCase
{
	public function testMain()
	{
		// data array
		$array[] = array('name' => 'Davy Hellemans', 'email' => 'davy@spoon-library.be');
		$array[] = array('name' => 'Tijs Verkoyen', 'email' => 'tijs@spoon-library.be');
		$array[] = array('name' => 'Dave Lens', 'email' => 'dave@spoon-library.be');

		// create source
		$source = new SpoonDatagridSourceArray($array);

		// create datagrid
		$dg = new SpoonDatagrid($source);
		self::assertInstanceOf(SpoonDataGrid::class, $dg);
	}

	public function testGetTemplate()
	{
		// data array
		$array[] = array('name' => 'Davy Hellemans', 'email' => 'davy@spoon-library.be');
		$array[] = array('name' => 'Tijs Verkoyen', 'email' => 'tijs@spoon-library.be');
		$array[] = array('name' => 'Dave Lens', 'email' => 'dave@spoon-library.be');

		// create source
		$source = new SpoonDatagridSourceArray($array);

		// create datagrid
		$dg = new SpoonDatagrid($source);

		// fetch instance
		self::assertInstanceOf(SpoonTemplate::class, $dg->getTemplate(), 'getTemplate should return an object of SpoonTemplate.');
	}
}
