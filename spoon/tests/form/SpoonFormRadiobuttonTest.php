<?php

use PHPUnit\Framework\TestCase;

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonFormRadiobuttonTest extends TestCase
{
	/**
	 * @var	SpoonForm
	 */
	protected $frm;

	/**
	 * @var	SpoonFormRadiobutton
	 */
	protected $rbtGender;

	/**
	 * @var	SpoonFormRadiobutton
	 */
	protected $rbtNumeric;

	public function setup(): void
	{
		$this->frm = new SpoonForm('radiobutton');
		$gender[] = array('label' => 'Female', 'value' => 'F');
		$gender[] = array('label' => 'Male', 'value' => 'M');
		$this->rbtGender = new SpoonFormRadiobutton('gender', $gender, 'M');
		$this->frm->add($this->rbtGender);

		$numeric = array(
			array('value' => 1,   'label' => 'One'),
			array('value' => 1.5, 'label' => 'One And A Half'),
		);
		$this->rbtNumeric = new SpoonFormRadiobutton('numeric', $numeric, '1');
	}

	public function testGetChecked()
	{
		$this->assertEquals('M', $this->rbtGender->getChecked());
	}

	public function testGetValue()
	{
		$_POST['form'] = 'radiobutton';
		$this->assertEquals('M', $this->rbtGender->getValue());
		$_POST['gender'] = 'F';
		$this->assertEquals('F', $this->rbtGender->getValue());
		$_POST['gender'] = array('foo', 'bar');
		$this->assertEquals('F', $this->rbtGender->getValue());
	}

	public function testIsFilled()
	{
		$_POST['form'] = 'radiobutton';
		$_POST['gender'] = 'M';
		$this->assertTrue($this->rbtGender->isFilled());
		$_POST['gender'] = 'foobar';
		$this->assertFalse($this->rbtGender->isFilled());
		$_POST['gender'] = array('foo', 'bar');
		$this->assertFalse($this->rbtGender->isFilled());
	}

	public function testIntegerValues()
	{
		$this->assertEquals('1', $this->rbtNumeric->getValue());

		$buttons = $this->rbtNumeric->parse();

		$expected = $this->getExpectedNumericArray('1');

		$this->assertEquals($buttons, $expected);
	}

	public function testFloatValues()
	{
		$this->rbtNumeric->setChecked(1.5);

		$this->assertEquals('1.5', $this->rbtNumeric->getValue());

		$buttons = $this->rbtNumeric->parse();

		$expected = $this->getExpectedNumericArray('1.5');

		$this->assertEquals($buttons, $expected);
	}

	protected function getExpectedNumericArray($checked)
	{
		$oneChecked = ($checked === '1') ? ' checked="checked"' : '';
		$oneHalfChecked = ($checked === '1.5') ? ' checked="checked"' : '';

		return array(
			array(
				'rbtNumeric' => '<input type="radio" name="numeric" value="1"' . $oneChecked . ' class="inputRadiobutton" id="numeric1" />',
				'id' => 'numeric1',
				'label' => 'One',
				'value' => '1',
				'element' => '<input type="radio" name="numeric" value="1"' . $oneChecked . ' class="inputRadiobutton" id="numeric1" />',
			),
			array(
				'rbtNumeric' => '<input type="radio" name="numeric" value="1.5"' . $oneHalfChecked . ' class="inputRadiobutton" id="numeric1.5" />',
				'id' => 'numeric1.5',
				'label' => 'One And A Half',
				'value' => '1.5',
				'element' => '<input type="radio" name="numeric" value="1.5"' . $oneHalfChecked . ' class="inputRadiobutton" id="numeric1.5" />',
			)
		);
	}
}
