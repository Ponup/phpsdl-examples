<?php

if( !extension_loaded( 'sdl' ) )
{
	fprintf( STDERR, 'ERROR: The SDL extension is not loaded.' . PHP_EOL );
	exit( 1 );
}

/**
 * Waits indefinitely until the user inputs something with his/her mouse or keyboard.
 */
function waitForInput()
{
	$event = null;
	while( SDL_WaitEvent( $event ) )
	{
		if( in_array( $event['type'], array( SDL_MOUSEBUTTONDOWN, SDL_KEYDOWN ) ) )
		{
			break;
		}
	}
}

