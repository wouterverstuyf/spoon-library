<?php

date_default_timezone_set('Europe/Brussels');

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonFormDateTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var	SpoonForm
	 */
	protected $frm;

	/**
	 * @var	SpoonFormDate
	 */
	protected $txtDate;

	public function setup()
	{
		$this->frm = new SpoonForm('datefield');
		$this->txtDate = new SpoonFormDate('date', strtotime('Last Monday'), 'd/m/Y');
		$this->frm->add($this->txtDate);
		$_POST['form'] = 'datefield';
	}

	public function testGetDefaultValue()
	{
		$this->assertEquals(date('d/m/Y', strtotime('Last Monday')), $this->txtDate->getDefaultValue());
	}

	public function testErrors()
	{
		$this->txtDate->setError('You suck');
		$this->assertEquals('You suck', $this->txtDate->getErrors());
		$this->txtDate->addError(' cock');
		$this->assertEquals('You suck cock', $this->txtDate->getErrors());
		$this->txtDate->setError('');
		$this->assertEquals('', $this->txtDate->getErrors());
	}

	public function testAttributes()
	{
		$this->txtDate->setAttribute('rel', 'bauffman.jpg');
		$this->assertEquals('bauffman.jpg', $this->txtDate->getAttribute('rel'));
		$this->txtDate->setAttributes(array('id' => 'specialID'));
		$this->assertEquals(array('id' => 'specialID', 'name' => 'date','maxlength' => 10, 'class' => 'inputDatefield', 'rel' => 'bauffman.jpg', 'data-mask' => 'dd/mm/yy'), $this->txtDate->getAttributes());
	}

	public function testIsFilled()
	{
		$this->assertFalse($this->txtDate->isFilled());
		$_POST['date'] = '12/10/2009';
		$this->assertTrue($this->txtDate->isFilled());
		$_POST['date'] = array('foo', 'bar');
		$this->assertTrue($this->txtDate->isFilled());
	}

	public function testIsValid()
	{
		$this->assertFalse($this->txtDate->isValid());
		$_POST['date'] = '29/02/1997';
		$this->assertFalse($this->txtDate->isValid());
		$_POST['date'] = '29/02/2000';
		$this->assertTrue($this->txtDate->isValid());
		$_POST['date'] = '31/04/2009';
		$this->assertFalse($this->txtDate->isValid());
		$_POST['date'] = array('foo', 'bar');
		$this->assertFalse($this->txtDate->isValid());
	}

	public function testGetTimestamp()
	{
		$_POST['date'] = '12/10/2009';
		$this->assertEquals('12/10/2009 12:13:14', date('d/m/Y H:i:s', $this->txtDate->getTimestamp(null, null, null, 12, 13, 14)));
		$this->assertEquals('12/10/2010 12:13:14', date('d/m/Y H:i:s', $this->txtDate->getTimestamp(2010, null, null, 12, 13, 14)));
		$this->assertEquals('12/11/2009 12:13:14', date('d/m/Y H:i:s', $this->txtDate->getTimestamp(null, 11, null, 12, 13, 14)));
		$this->assertEquals('25/10/2009 12:13:14', date('d/m/Y H:i:s', $this->txtDate->getTimestamp(null, null, 25, 12, 13, 14)));

		$_POST['date'] = array('foo', 'bar');
		$this->assertEquals(date('Y-m-d H:i:s'), date('Y-m-d H:i:s', $this->txtDate->getTimestamp()));
	}

	public function testGetValue()
	{
		$_POST['form'] = 'datefield';
		$_POST['date'] = '12/10/2009';
		$this->assertEquals('12/10/2009', $this->txtDate->getValue());

		$_POST['date'] = array('foo', 'bar');
		$this->assertEquals('Array', $this->txtDate->getValue());
	}

	public function testDateFormatsLong()
	{
		$formats = unserialize('a:14:{i:0;s:5:"j F Y";i:1;s:7:"D j F Y";i:2;s:7:"l j F Y";i:3;s:6:"j F, Y";i:4;s:8:"D j F, Y";i:5;s:8:"l j F, Y";i:6;s:5:"d F Y";i:7;s:6:"d F, Y";i:8;s:5:"F j Y";i:9;s:7:"D F j Y";i:10;s:7:"l F j Y";i:11;s:6:"F d, Y";i:12;s:8:"D F d, Y";i:13;s:8:"l F d, Y";}');
		$this->loopOverFormats($formats);
	}

	/**
	 * Loop over formats and test if they work.
	 *
	 * @param array $formats
	 */
	private function loopOverFormats(array $formats)
	{
		foreach ($formats as $format) {
			$timestamp = strtotime('Last Monday');
			$date = date($format, $timestamp);

			// set up the form
			$form = new SpoonForm('formattedDateFieldForm');
			$txtFormattedDate = new SpoonFormDate('formattedDate', $timestamp, $format);
			$form->add($txtFormattedDate);

			// the actual test
			$this->assertEquals($date, $txtFormattedDate->getValue(), $format . ' failed');
		}
	}

	public function testDateFormatsShort()
	{
		$formats = unserialize('a:24:{i:0;s:5:"j/n/Y";i:1;s:5:"j-n-Y";i:2;s:5:"j.n.Y";i:3;s:5:"n/j/Y";i:4;s:5:"n/j/Y";i:5;s:5:"n/j/Y";i:6;s:5:"d/m/Y";i:7;s:5:"d-m-Y";i:8;s:5:"d.m.Y";i:9;s:5:"m/d/Y";i:10;s:5:"m-d-Y";i:11;s:5:"m.d.Y";i:12;s:5:"j/n/y";i:13;s:5:"j-n-y";i:14;s:5:"j.n.y";i:15;s:5:"n/j/y";i:16;s:5:"n-j-y";i:17;s:5:"n.j.y";i:18;s:5:"d/m/y";i:19;s:5:"d-m-y";i:20;s:5:"d.m.y";i:21;s:5:"m/d/y";i:22;s:5:"m-d-y";i:23;s:5:"m.d.y";}');
		$this->loopOverFormats($formats);
	}
}
