<?php
/**
 * Example of how to draw pixels on the screen in batch using the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

require 'common.php';

SDL_Init( SDL_INIT_VIDEO );

$screen = SDL_SetVideoMode( 320, 240, 16, SDL_SWSURFACE );

$dotColor = SDL_MapRGB( $screen['format'], 255, 255, 255 );

$length = intval( $screen['w'] / 5 );
$x = 0;
$pixels = array();

while( $x < 256 )
{
	$angle = $x * M_PI / 128;
	$y = $length * sin( $angle );

	$pixels[] = array(
		'x' => $x ,
		'y' => intval( $screen['h'] / 2 + $y ),
		'pixel' => $dotColor
	);

	$x += 5;
}

SDL_PutPixels( $screen, $pixels );
SDL_Flip( $screen );

waitForInput();

SDL_Quit();

