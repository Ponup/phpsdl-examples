<?php

dl( 'sdl.' . PHP_SHLIB_SUFFIX );

require 'Fps.php';
require 'Ball.php';
require 'Engine.php';
require 'Image.php';
require 'Window.php';

$engine = new Engine;
$engine->init();

$bgImage = new BmpImage( 'images/background.bmp' );

$window = new Window;
$window->setTitle( 'Gravity' );

$ball = new Ball;
$fps = new FPS( 70 );

$quit = false;
$event = array( 'type' => null );
while( !$quit )
{
	SDL_BlitSurface( $bgImage->getSurface(), null, $window->getSurface(), null );
	
	$rep = $fps->update();
	for( $i = 0; $i < $rep; $i++ )
		$ball->update();

	$ball->draw( $window->getSurface() );

	$window->update();

	while( SDL_PollEvent( $event ) )
	{
		$quit = in_array( $event['type'], array( SDL_QUIT, SDL_KEYDOWN ) );
	}
}

unset( $fps );
unset( $ball );
unset( $bgImage );

$engine->destroy();

