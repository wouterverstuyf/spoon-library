<?php

/**
 * POPO to test spoon template with
 */
class Object
{
	protected $name;
	protected $nestedObject;
	protected $array;
	protected $boolean;

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

	public function isBoolean()
	{
		return $this->boolean;
	}

	public function setBoolean($boolean)
	{
		$this->boolean = $boolean;

		return $this;
	}
}
