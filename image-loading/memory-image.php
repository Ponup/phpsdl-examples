<?php	

/**
 * Example of how to load an image from memory (an array) an draw it on the screen using the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

require '../common.php';
require 'image.php';

if( SDL_Init( SDL_INIT_VIDEO ) < 0 )
{
	exit( 1 );
}

$imageSpec = array(
	'w' => 95,
	'h' => 51,
	'bpp' => 4,
	'pixels' => $image
);

$screenWidth = ( $imageSpec['w'] + 100 );
$screenHeight = ( $imageSpec['h'] + 100 );
$screen = SDL_SetVideoMode( $screenWidth, $screenHeight, 8, SDL_HWSURFACE );

if( null === $screen )
{
	SDL_Quit();

	exit(1);
}
$color = SDL_MapRGB( $screen['format'], 0xff, 0xff, 0xff );
SDL_FillRect( $screen,
	array(
		'x' => 0, 'y' => 0,
		'w' => $screenWidth, 'h' => $screenHeight
	),
	$color
);

$image = SDL_CreateRGBSurfaceFrom( $imageSpec['pixels'], $imageSpec['w'], $imageSpec['h'], $imageSpec['bpp'] * 8, $imageSpec['w'] * $imageSpec['bpp'], 0x000000ff, 0x0000ff00, 0x00ff0000, 0xff000000 );

$dest = array(
	'x' => ( ( $screen['w'] - $image['w'] ) >> 1 ),
	'y' => ( ( $screen['h'] - $image['h'] ) >> 1 ),
	'w' => $image['w'],
	'h' => $image['h'],
);

SDL_BlitSurface( $image, null, $screen, $dest );

SDL_Flip( $screen );

waitForInput();

SDL_FreeSurface( $image );
SDL_FreeSurface( $screen );

SDL_Quit();

