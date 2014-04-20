<?php
/**
 * Example of how to adjust the viewport based on the mouse movements and position using the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

require '../common.php';

dl( 'sdl_image.' . PHP_SHLIB_SUFFIX );

SDL_Init( SDL_INIT_VIDEO );

$earthImage = IMG_Load( 'earth.jpg' );

$screen = SDL_SetVideoMode( 320, 768, 0, 0 );

if( $earthImageOptimized = SDL_DisplayFormat( $earthImage ) )
{
	$earthImage = $earthImageOptimized;
}
	
$mouseX = $screen['w'] >> 1;
$mouseY = $screen['h'] >> 1;

SDL_WarpMouse( $mouseX, $mouseY );
SDL_ShowCursor( true );
SDL_WM_GrabInput( SDL_GRAB_OFF );

$mainloop = true;
$imageOffset = 0;

function update()
{
	global $screen, $imageOffset, $earthImage;

	if( $imageOffset > $earthImage['w'] - $screen['w'] )
	{
		$imageOffset = $earthImage['w'] - $screen['w'];
		return;
	}

	if( $imageOffset < 0 )
	{
		$imageOffset = 0;
		return;
	}

	$rect = array(
		'x' => $imageOffset, 'y' => 0,
		'w' => $screen['w'], 'h' => $screen['h'],
	);

	SDL_BlitSurface( $earthImage, $rect, $screen, null );
	SDL_UpdateRect( $screen, 0, 0, 0, 0 );
}

update();

$event = null;
while( $mainloop )
{
	while( SDL_PollEvent( $event ) )
	{
		switch( $event['type'] )
		{
			case SDL_MOUSEMOTION:
				if( $event['motion']['xrel'] == 0 )
					break;
				$imageOffset += $event['motion']['xrel'] * 2.5;
				update();
				break;
			case SDL_KEYDOWN:
				if( $event['key']['keysym']['sym'] != SDLK_ESCAPE )
					break;
			case SDL_MOUSEBUTTONDOWN:
			case SDL_QUIT:
				$mainloop = false;
				break;
		}
	}
}

SDL_Quit();

