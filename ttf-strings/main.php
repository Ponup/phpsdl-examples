<?php
/**
 * Example of how to draw strings using TTF fonts with the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

require '../common.php';

dl( 'sdl_ttf.' . PHP_SHLIB_SUFFIX );

if( !extension_loaded( 'sdl_ttf' ) )
{
	fprintf( STDERR, 'The extension sdl_ttf must be installed to run this script.' . PHP_EOL );
	exit( 1 );
}

if( SDL_Init( SDL_INIT_VIDEO ) < 0 )
{
	fprintf( STDERR, 'SDL could not be initialized.' . PHP_EOL );
	exit( 1 );
}

$screen = SDL_SetVideoMode( 640, 480, 16, SDL_HWSURFACE );
if( null === $screen )
{
	fprintf( STDERR, 'Unable to create a new Window with the desired arguments.' . PHP_EOL );
	exit( 1 );
}

SDL_WM_SetCaption( $title = 'True type font', $title );

TTF_Init();

$font = TTF_OpenFont( 'FreeSans.ttf', 30 );
$fontHeight = TTF_FontLineSkip( $font );

$fontSurf = TTF_RenderUTF8_Solid( $font, 'Amor Vincit Omnia', array( 'r' => 255, 'g' => 100, 'b' => 20 ) );
SDL_BlitSurface($fontSurf, null, $screen, array( 'x' => 40, 'y' => 60 ) );

$fontSurf = TTF_RenderUTF8_Blended( $font, 'Love conquers all things', array( 'r' => 100, 'g' => 100, 'b' => 200 ) );
SDL_BlitSurface($fontSurf, null, $screen, array( 'x' => 40, 'y' => 60 + $fontHeight ) );

$fontSurf = TTF_RenderUTF8_Blended( $font, 'El amor lo conquista todo', array( 'r' => 50, 'g' => 255, 'b' => 0 ) );
SDL_BlitSurface( $fontSurf, null, $screen, array( 'x' => 40, 'y' => 60 + $fontHeight * 2 ) );

SDL_Flip( $screen );

waitForInput();

TTF_Quit();

SDL_Quit();

