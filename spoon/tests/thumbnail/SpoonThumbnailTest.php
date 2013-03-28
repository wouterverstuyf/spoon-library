<?php

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';
require_once 'PHPUnit/Framework/TestCase.php';

class SpoonThumbnailTest extends PHPUnit_Framework_TestCase
{
	public function testIsSupportedFileType()
	{
		$this->assertTrue(
			SpoonThumbnail::isSupportedFileType(dirname(dirname(realpath(__FILE__))) . '/tmp/spoon.jpg')
		);
	}
}
