<?php

dl( 'sdl.' . PHP_SHLIB_SUFFIX );

/**
 * Example of how to load a BMP image from disk and draw it on the screen using the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

if( SDL_Init( SDL_INIT_VIDEO ) < 0 )
{
	trigger_error( 'SDL can not be initialized. Exiting.' );
	exit( 1 );
}

// Create a Window of 640x480, 16 bits of depth
$screen = SDL_SetVideoMode( 640, 480, 16, SDL_HWSURFACE );
if( null === $screen )
{
	trigger_error( 'Unable to create a new Window with the desired arguments.' );
	exit(1);
}

SDL_WM_SetCaption( $title = 'BMP image loading', $title );

// Load a BMP image from filesystem
$img = SDL_LoadBMP( 'boy.bmp' );
if( null === $img )
{
	trigger_error( 'Unable to load the specified image.' );
	exit( 1 );
}

// Put the image on memory on the screen buffer
SDL_BlitSurface( $img, null, $screen, array( 'x' => 290, 'y' => 210 ) );

// Refresh the whole screen
SDL_flip( $screen );

$quit = false;
$event = array( 'type' => null );
while( $quit === false )
{
	SDL_WaitEvent( $event );
	switch( $event['type'] )
	{
		case SDL_KEYDOWN:
		case SDL_MOUSEBUTTONDOWN:
		case SDL_QUIT:
			$quit = true;
			break;
	}
}

SDL_FreeSurface( $img );

SDL_Quit();

