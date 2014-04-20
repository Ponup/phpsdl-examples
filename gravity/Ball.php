<?php

require 'Point.php';
require 'Sprite.php';
require 'Color.php';

class Ball
{
	/**
	 * @var Point
	 */
	private $position;

	/**
	 * @var Sprite
	 */
	private $sprite;

	private $dx;
	private $vel_y;
	
	public function __construct()
	{
		$this->position = new Point( 150, 50 );

		$this->dx = 2;
		$this->vel_y = 0;

		$transparentColor = new Color( 255, 0, 255 );

		$this->sprite = new Sprite( $transparentColor );
		$this->sprite->addFrame( 'images/ball-sprite1.bmp' );
		$this->sprite->addFrame( 'images/ball-sprite2.bmp' );
	}

	public function __destruct()
	{
		unset( $this->position );
		unset( $this->sprite );
	}

	public function update()
	{
		$this->position->addX( $this->dx );
		$this->vel_y += 0.1;

		if( $this->position->getY() + $this->vel_y >= 176 )
		{
			$this->vel_y -= 0.1;
			$this->vel_y *= -1;
			$this->position->setY( 176 );
		}
		else
		{
			$this->position->addY( $this->vel_y );
		}

		if( $this->position->getX() >= 302)
			$this->dx = -2;

		if( $this->position->getX() < 0)
			$this->dx = 2;
	}

	public function draw( $screen )
	{
		$dest = array(
			'x' => $this->position->getX(),
			'y' => $this->position->getY(),
			'w' => 20,
			'h' => 20
		);

		$this->sprite->draw( $screen, $dest );
	}
}

