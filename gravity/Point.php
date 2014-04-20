<?php

function Point( $x, $y )
{
	return new Point( $x, $y );
}

class Point
{
	private $x;
	private $y;

	public function __construct( $x = 0, $y = 0 )
	{
		$this->x = $x;
		$this->y = $y;
	}

	public function setX( $x )
	{
		$this->x = $x;
	}

	public function getX()
	{
		return $this->x;
	}

	public function addX( $x )
	{
		$this->x += $x;
	}

	public function setY( $y )
	{
		$this->y = $y;
	}

	public function getY()
	{
		return $this->y;
	}

	public function addY( $y )
	{
		$this->y += $y;
	}

	public function __toString()
	{
		return sprintf( 'Point[x=%d, y=%d]', $this->x, $this->y );
	}
}

