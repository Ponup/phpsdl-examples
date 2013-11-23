<?php

if( !extension_loaded( 'sdl' ) )
{
	fprintf( STDERR, 'ERROR: The SDL extension is not loaded.' . PHP_EOL );
	exit( 1 );
}

