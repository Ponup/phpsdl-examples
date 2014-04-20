<?php
/**
 * Example of how to apply some transformations (rotation, scaling) to images using the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

require '../common.php';

dl( 'sdl_image.' . PHP_SHLIB_SUFFIX );
dl( 'sdl_gfx.' . PHP_SHLIB_SUFFIX );

if( !extension_loaded( 'sdl_gfx' ) )
{
	fprintf( STDERR, 'The extension sdl_gfx must be installed to run this script.' . PHP_EOL );
	exit( 1 );
}

define( 'PI_2TIMES', M_PI * 2 );

if( SDL_Init( SDL_INIT_VIDEO ) == -1 ) 
{
	printf( 'Error: %s\n', SDL_GetError());
	return 1;
}

$window = SDL_SetVideoMode( 300, 300, 16, SDL_SWSURFACE );

if( null === $window )
{
	printf( "Error: %s\n", SDL_GetError() );
	return 1;
}

function clear( $screen, $x, $y, $w, $h )
{
	$rect = array(
		'x' => $x,
		'y' => $y,
		'w' => $w,
		'h' => $h
	);
	$color = SDL_MapRGB( $screen['format'], 20, 100, 20 );
	SDL_FillRect( $screen, $rect, $color );
}

$quit = false;
$angle = 0;
$zoom = 1;

$mailImage = IMG_Load( 'images/mail.png' );
$stopImage = IMG_Load( 'images/stop.png' );

$rect1 = array(
	'x' => 150, 'y' => 150,
	'w' => 100, 'h' => 100,
);
$rect2 = array(
	'x' => 100, 'y' => 100,
	'w' => 100, 'h' => 100,
);

$event = array( 'type' => null );
while( !$quit )
{
	while( SDL_PollEvent( $event ) )
	{
		switch( $event['type'] )
		{
			case SDLK_q:
			case SDL_QUIT :
				$quit = true;
				break;
		}
	}

	if( $angle < 360 )
	{
		$angle = $angle + 1;
		$zoom = ( $angle * PI_2TIMES ) / 360;
		$mailImageRotated = gfx_rotozoomSurface( $mailImage['handle'], $angle, abs( sin( $zoom ) ), 1 );
		SDL_BlitSurface( $mailImageRotated, null, $window, null );
		$stopImageRotated = gfx_rotozoomSurface( $stopImage['handle'], $angle, abs( cos( $zoom ) ), 1 );

		$rect1['x'] = 190 - $mailImageRotated['w'] / 2;
		$rect1['y'] = 150 - $mailImageRotated['h'] / 2;
		$rect1['w'] = $rect1['h'] = 100;

		$rect2['x'] = 110 - $stopImageRotated['w'] / 2;
		$rect2['y'] = 150 - $stopImageRotated['h'] / 2;
		$rect2['w'] = $rect2['h'] = 100;

		clear($window, 0, 0, $window['w'], $window['h'] );
		SDL_BlitSurface( $mailImageRotated, null, $window, $rect1 );
		SDL_BlitSurface( $stopImageRotated, null, $window, $rect2 );
		SDL_FreeSurface( $mailImageRotated );
		SDL_FreeSurface( $stopImageRotated );
		SDL_Flip( $window );
	}
	else $angle = 0;
	
	SDL_Delay( 10 );
}

SDL_FreeSurface( $mailImage );
SDL_FreeSurface( $stopImage );

SDL_Quit();

