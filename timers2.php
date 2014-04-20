<?php

require 'common.php';

SDL_Init(SDL_INIT_TIMER);

$quit = false;

$callback = function( $data ) use( &$quit ) {
	echo 'Receiving data... (2 seconds later)', PHP_EOL;
	var_dump( $data );
	$quit = true;
	return 0;
};

$temp = array( 'utime' => 'foo', 'rail' => microtime( true ) );
$timerId = SDL_AddTimer( 2000, $callback, $temp );

while( !$quit ) {
	SDL_Delay( 60 );
}

//SDL_RemoveTimer( $timerId );

