<?php

class Color
{
	private $red;
	private $green;
	private $blue;

	public function __construct( $red = 255, $green = 0, $blue = 0 )
	{
		$this->red = $red;
		$this->green = $green;
		$this->blue = $blue;
	}

	public function getRed()
	{
		return $this->red;
	}

	public function getGreen()
	{
		return $this->green;
	}

	public function getBlue()
	{
		return $this->blue;
	}
}

