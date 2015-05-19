<?php

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonFormRadiobuttonTest extends PHPUnit_Framework_TestCase
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

	/**
	 * @var	SpoonFormRadiobutton
	 */
	protected $rbtNumericWithValueZeroAndCheckedNull;
	protected $rbtNumericWithValueZeroAndCheckedZero;
	protected $rbtNumericWithValueZeroAndCheckedOne;
	protected $rbtBooleanCheckedNull;
	protected $rbtBooleanCheckedFalse;
	protected $rbtBooleanCheckedTrue;

	public function setup()
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

		$numericWithValueZero = array(
			array('value' => 0,   'label' => 'Zero'),
			array('value' => 1,   'label' => 'One'),
			array('value' => 1.5, 'label' => 'One And A Half'),
			array('value' => 2,   'label' => 'Two'),
		);
		$this->rbtNumericWithValueZeroAndCheckedNull =
			new SpoonFormRadiobutton(
				'numeric_with_value_zero_checked_null',
				$numericWithValueZero
			);
		$this->rbtNumericWithValueZeroAndCheckedZero =
			new SpoonFormRadiobutton(
				'numeric_with_value_zero_checked_zero',
				$numericWithValueZero,
				0
			);
		$this->rbtNumericWithValueZeroAndCheckedOne =
			new SpoonFormRadiobutton(
				'numeric_with_value_zero_checked_one',
				$numericWithValueZero,
				1
			);

		$boolean = array(
			array('value' => true, 'label' => 'True'),
			array('value' => false, 'label' => 'False'),
		);
		$this->rbtBooleanCheckedNull =
			new SpoonFormRadiobutton('boolean_checked_null', $boolean);
		$this->rbtBooleanCheckedFalse =
			new SpoonFormRadiobutton('boolean_checked_false', $boolean, false);
		$this->rbtBooleanCheckedTrue =
			new SpoonFormRadiobutton('boolean_checked_true', $boolean, true);
	}

	public function testNumericWithValueZeroAndCheckedNull($on = false)
	{
		if(!$on) return true;

		$this->assertSame(
			null,
			$this->rbtNumericWithValueZeroAndCheckedNull->getChecked(),
			'No value (null) was set for this radiobutton: null should be equal to null.'
		);
		$this->assertNotSame(
			0,
			$this->rbtNumericWithValueZeroAndCheckedNull->getChecked(),
			'No value (null) was set for this radiobutton: 0 (zero) should NOT be equal to null.'
		);
		$this->assertNotSame(
			false,
			$this->rbtNumericWithValueZeroAndCheckedNull->getChecked(),
			'No value (null) was set for this radiobutton: false should NOT be equal to null'
		);
	}

	public function testNumericWithValueZeroAndCheckedNullParsed($on = true)
	{
		if(!$on) return true;

		$this->assertEquals(
			array(
				array(
					'rbtNumericWithValueZeroCheckedNull' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="0" class="inputRadiobutton" id="numericWithValueZeroCheckedNull0" />',
					'id' => 'numericWithValueZeroCheckedNull0',
					'label' => 'Zero',
					'value' => '0',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="0" class="inputRadiobutton" id="numericWithValueZeroCheckedNull0" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedNull' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="1" class="inputRadiobutton" id="numericWithValueZeroCheckedNull1" />',
					'id' => 'numericWithValueZeroCheckedNull1',
					'label' => 'One',
					'value' => '1',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="1" class="inputRadiobutton" id="numericWithValueZeroCheckedNull1" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedNull' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="1.5" class="inputRadiobutton" id="numericWithValueZeroCheckedNull1.5" />',
					'id' => 'numericWithValueZeroCheckedNull1.5',
					'label' => 'One And A Half',
					'value' => '1.5',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="1.5" class="inputRadiobutton" id="numericWithValueZeroCheckedNull1.5" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedNull' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="2" class="inputRadiobutton" id="numericWithValueZeroCheckedNull2" />',
					'id' => 'numericWithValueZeroCheckedNull2',
					'label' => 'Two',
					'value' => '2',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_null" value="2" class="inputRadiobutton" id="numericWithValueZeroCheckedNull2" />',
				)
			),
			$this->rbtNumericWithValueZeroAndCheckedNull->parse(),
			'Parsed radiobutton does not match expected: nothing should be checked.'
		);
	}

	public function testNumericWithValueZeroAndCheckedZero($on = false)
	{
		if(!$on) return true;

		$this->assertSame(
			0,
			$this->rbtNumericWithValueZeroAndCheckedZero->getChecked(),
			'Value 0 (zero) was set for this radiobutton: 0 should be equal to 0 (zero).'
		);
		$this->assertNotSame(
			null,
			$this->rbtNumericWithValueZeroAndCheckedZero->getChecked(),
			'Value 0 (zero) was set for this radiobutton: null should NOT be equal to 0 (zero).'
		);
		$this->assertNotSame(
			false,
			$this->rbtNumericWithValueZeroAndCheckedZero->getChecked(),
			'Value 0 (zero) was set for this radiobutton: false should NOT be equal to 0 (zero)'
		);
	}

	public function testNumericWithValueZeroAndCheckedZeroParsed($on = true)
	{
		if(!$on) return true;

		$this->assertEquals(
			array(
				array(
					'rbtNumericWithValueZeroCheckedZero' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="0" checked="checked" class="inputRadiobutton" id="numericWithValueZeroCheckedZero0" />',
					'id' => 'numericWithValueZeroCheckedZero0',
					'label' => 'Zero',
					'value' => '0',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="0" checked="checked" class="inputRadiobutton" id="numericWithValueZeroCheckedZero0" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedZero' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="1" class="inputRadiobutton" id="numericWithValueZeroCheckedZero1" />',
					'id' => 'numericWithValueZeroCheckedZero1',
					'label' => 'One',
					'value' => '1',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="1" class="inputRadiobutton" id="numericWithValueZeroCheckedZero1" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedZero' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="1.5" class="inputRadiobutton" id="numericWithValueZeroCheckedZero1.5" />',
					'id' => 'numericWithValueZeroCheckedZero1.5',
					'label' => 'One And A Half',
					'value' => '1.5',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="1.5" class="inputRadiobutton" id="numericWithValueZeroCheckedZero1.5" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedZero' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="2" class="inputRadiobutton" id="numericWithValueZeroCheckedZero2" />',
					'id' => 'numericWithValueZeroCheckedZero2',
					'label' => 'Two',
					'value' => '2',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_zero" value="2" class="inputRadiobutton" id="numericWithValueZeroCheckedZero2" />',
				)
			),
			$this->rbtNumericWithValueZeroAndCheckedZero->parse(),
			'Parsed radiobutton does not match expected: 0 (zero) should be checked.'
		);
	}

	public function testNumericWithValueZeroAndCheckedOne($on = true)
	{
		if(!$on) return true;

		$this->assertSame(
			1,
			$this->rbtNumericWithValueZeroAndCheckedOne->getChecked(),
			'Value 1 was set for this radiobutton: 1 should be equal to 1.'
		);
		$this->assertNotSame(
			null,
			$this->rbtNumericWithValueZeroAndCheckedOne->getChecked(),
			'Value 1 was set for this radiobutton: null should NOT be equal to 1.'
		);
		$this->assertNotSame(
			false,
			$this->rbtNumericWithValueZeroAndCheckedOne->getChecked(),
			'Value 1 was set for this radiobutton: false should NOT be equal to 1'
		);
	}

	public function testNumericWIthValueZeroAndCheckedOneParsed($on = true)
	{
		if(!$on) return true;

		$this->assertEquals(
			array(
				array(
					'rbtNumericWithValueZeroCheckedOne' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="0" class="inputRadiobutton" id="numericWithValueZeroCheckedOne0" />',
					'id' => 'numericWithValueZeroCheckedOne0',
					'label' => 'Zero',
					'value' => '0',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="0" class="inputRadiobutton" id="numericWithValueZeroCheckedOne0" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedOne' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="1" checked="checked" class="inputRadiobutton" id="numericWithValueZeroCheckedOne1" />',
					'id' => 'numericWithValueZeroCheckedOne1',
					'label' => 'One',
					'value' => '1',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="1" checked="checked" class="inputRadiobutton" id="numericWithValueZeroCheckedOne1" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedOne' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="1.5" class="inputRadiobutton" id="numericWithValueZeroCheckedOne1.5" />',
					'id' => 'numericWithValueZeroCheckedOne1.5',
					'label' => 'One And A Half',
					'value' => '1.5',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="1.5" class="inputRadiobutton" id="numericWithValueZeroCheckedOne1.5" />',
				),
				array(
					'rbtNumericWithValueZeroCheckedOne' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="2" class="inputRadiobutton" id="numericWithValueZeroCheckedOne2" />',
					'id' => 'numericWithValueZeroCheckedOne2',
					'label' => 'Two',
					'value' => '2',
					'element' => '<input type="radio" name="numeric_with_value_zero_checked_one" value="2" class="inputRadiobutton" id="numericWithValueZeroCheckedOne2" />',
				)
			),
			$this->rbtNumericWithValueZeroAndCheckedOne->parse(),
			'Parsed radiobutton does not match expected: 1 should be checked.'
		);
	}

	public function testBooleanCheckedNull($on = true)
	{
		if(!$on) return true;

		$this->assertSame(
			null,
			$this->rbtBooleanCheckedNull->getChecked(),
			'No value was set for this radiobutton: null should be equal to null.'
		);
		$this->assertNotSame(
			true,
			$this->rbtBooleanCheckedNull->getChecked(),
			'No value was set for this radiobutton: true should NOT be equal to null.'
		);
		$this->assertNotSame(
			false,
			$this->rbtBooleanCheckedNull->getChecked(),
			'No value was set for this radiobutton: false should NOT be equal to null.'
		);
	}

	public function testBooleanCheckedNullParsed($on = true)
	{
		if(!$on) return true;

		$this->assertEquals(
			array(
				array(
					'rbtBooleanCheckedNull' => '<input type="radio" name="boolean_checked_null" value="1" class="inputRadiobutton" id="booleanCheckedNull1" />',
					'id' => 'booleanCheckedNull1',
					'label' => 'True',
					'value' => '1',
					'element' => '<input type="radio" name="boolean_checked_null" value="1" class="inputRadiobutton" id="booleanCheckedNull1" />',
				),
				array(
					'rbtBooleanCheckedNull' => '<input type="radio" name="boolean_checked_null" value="" class="inputRadiobutton" id="booleanCheckedNull" />',
					'id' => 'booleanCheckedNull',
					'label' => 'False',
					'value' => '',
					'element' => '<input type="radio" name="boolean_checked_null" value="" class="inputRadiobutton" id="booleanCheckedNull" />',
				)
			),
			$this->rbtBooleanCheckedNull->parse(),
			'Parsed radiobutton does not match expected: nothing should be checked.'
		);
	}

	public function testBooleanCheckedFalse($on = true)
	{
		if(!$on) return true;

		$this->assertSame(
			false,
			$this->rbtBooleanCheckedFalse->getChecked(),
			'Value false was set for this radiobutton: false should be equal to false.'
		);
		$this->assertNotSame(
			null,
			$this->rbtBooleanCheckedFalse->getChecked(),
			'Value false was set for this radiobutton: null should NOT be equal to false.'
		);
		$this->assertNotSame(
			true,
			$this->rbtBooleanCheckedFalse->getChecked(),
			'Value false was set for this radiobutton: true should NOT be equal to false.'
		);
	}

	public function testBooleanCheckedFalseParsed($on = true)
	{
		if(!$on) return true;

		$this->assertEquals(
			array(
				array(
					'rbtBooleanCheckedFalse' => '<input type="radio" name="boolean_checked_false" value="1" checked="checked" class="inputRadiobutton" id="booleanCheckedFalse1" />',
					'id' => 'booleanCheckedFalse1',
					'label' => 'True',
					'value' => '1',
					'element' => '<input type="radio" name="boolean_checked_false" value="1" checked="checked" class="inputRadiobutton" id="booleanCheckedFalse1" />',
				),
				array(
					'rbtBooleanCheckedFalse' => '<input type="radio" name="boolean_checked_false" value="" class="inputRadiobutton" id="booleanCheckedFalse" />',
					'id' => 'booleanCheckedFalse',
					'label' => 'False',
					'value' => '',
					'element' => '<input type="radio" name="boolean_checked_false" value="" class="inputRadiobutton" id="booleanCheckedFalse" />',
				)
			),
			$this->rbtBooleanCheckedFalse->parse(),
			'Parsed radiobutton does not match expected: false should be checked.'
		);
	}

	public function testBooleanCheckedTrue($on = true)
	{
		if(!$on) return true;

		$this->assertSame(
			true,
			$this->rbtBooleanCheckedTrue->getChecked(),
			'Value true was set for this radiobutton: true should be equal to true.'
		);
		$this->assertNotSame(
			null,
			$this->rbtBooleanCheckedTrue->getChecked(),
			'Value true was set for this radiobutton: null should NOT be equal to true.'
		);
		$this->assertNotSame(
			false,
			$this->rbtBooleanCheckedTrue->getChecked(),
			'Value true was set for this radiobutton: false should NOT be equal to true.'
		);
	}

	public function testBooleanCheckedTrueParsed($on = true)
	{
		if(!$on) return true;

		$this->assertEquals(
			array(
				array(
					'rbtBooleanCheckedTrue' => '<input type="radio" name="boolean_checked_true" value="1" class="inputRadiobutton" id="booleanCheckedTrue1" />',
					'id' => 'booleanCheckedTrue1',
					'label' => 'True',
					'value' => '1',
					'element' => '<input type="radio" name="boolean_checked_true" value="1" class="inputRadiobutton" id="booleanCheckedTrue1" />',
				),
				array(
					'rbtBooleanCheckedTrue' => '<input type="radio" name="boolean_checked_true" value="" checked="checked" class="inputRadiobutton" id="booleanCheckedTrue" />',
					'id' => 'booleanCheckedTrue',
					'label' => 'False',
					'value' => '',
					'element' => '<input type="radio" name="boolean_checked_true" value="" checked="checked" class="inputRadiobutton" id="booleanCheckedTrue" />',
				)
			),
			$this->rbtBooleanCheckedTrue->parse(),
			'Parsed radiobutton does not match expected: true should be checked.'
		);
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
