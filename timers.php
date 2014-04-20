<?php

require 'common.php';

SDL_Init(SDL_INIT_TIMER);

$interval = 1000;
$diff = 10;
$quit = false;

$callback = function() use( &$interval, &$diff, &$quit ) {
	if( $quit ) return;

	printf('waiting %d...'.PHP_EOL, $interval);
	$interval -= $diff;
	$diff += 10;
	if( $interval <= 0 ) $quit = true;
	return $interval;
};

$timerId = SDL_AddTimer( 50, $callback, null );

while( !$quit ) {
	SDL_Delay( 60 );
}

//SDL_RemoveTimer($timerId);

echo 'Quitting normally!', PHP_EOL;

