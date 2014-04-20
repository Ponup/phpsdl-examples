<?php

require 'common.php';

/* Port of stars.c by Nathan Strong */

set_time_limit(0);

$video = array();
$colors = array();
$xoff = 0;
$yoff = 0;
$angle = 0.0;
$frames = 0;
$stars = array();
$starsr = array();
$old = array();

$fps = 0.0;
$i = 0;
$x = 0;
$y = 0;
$oldx = 0;
$oldy = 0;
$color = 0;

if ( isset( $argv[1] ) && $argv[1] == "-hw" ) {
	InitGraphics(SDL_HWSURFACE);
} else {
	InitGraphics(SDL_SWSURFACE);
}

InitStars( $stars );

$st = time(NULL);

do {
	if ( SDL_MUSTLOCK($video) ) {
		if ( SDL_LockSurface($video) < 0 )
			continue;
	}
	unset($pixels);
	$pixels = array();
	for ($i = 0; $i < 100; $i++)
	{
		$old[$i][0] = $starsr[$i][0];
		$old[$i][1] = $starsr[$i][1];
		$old[$i][2] = $starsr[$i][2];

		$starsr[$i][0] = $stars[$i][0];
		$starsr[$i][1] = $stars[$i][1];
		$starsr[$i][2] = $stars[$i][2];

		Transform( $starsr[$i][1], $starsr[$i][2]);
		Transform( $starsr[$i][0], $starsr[$i][2]);
		Transform( $starsr[$i][0], $starsr[$i][1]);

		$oldx = (int) floor(((256*$old[$i][0])/($old[$i][2]-1024))+$xoff);
		$oldy = (int) floor(((256*$old[$i][1])/($old[$i][2]-1024))+$yoff);

		$x = (int) floor(((256*$starsr[$i][0])/($starsr[$i][2]-1024))+$xoff);
		$y = (int) floor(((256*$starsr[$i][1])/($starsr[$i][2]-1024))+$yoff);
	
		$color = floor(($starsr[$i][2] + 721) / 5.5);
		
		$color = rand( 0, count($colors)-1);
		$pixels[] = array('x' => $oldx, 'y' => $oldy, 'pixel' => $colors[0]);
		$pixels[] = array('x' => $x, 'y' => $y, 'pixel' => $colors[$color]);
		
	}
	
	SDL_putpixels($video, $pixels);
	
	if ( SDL_MUSTLOCK($video) ) {
		SDL_UnlockSurface($video);
	}
	SDL_UpdateRect($video, 0, 0, 0, 0);
	$frames++;
	$angle += 0.5;
} while( SDL_PollEvent() == 0);

if ((time(NULL) - $st) != 0) {
	$fps = (double)$frames / (time(NULL) - $st);
}

printf("%2.2f frames per second\n", $fps);

function Transform(&$ta, &$tb)
{
	global $angle;

	$y = 0.0;
	$z = 0.0;
	$y = (cos(($angle / 20)) * $ta) - (sin(($angle / 20)) * $tb);
	$z = (sin(($angle / 20)) * $ta) + (cos(($angle / 20)) * $tb);
	$ta = (int) floor($y);
	$tb = (int) floor($z);
}

function InitStars( &$stars ) 
{
	global $stars, $starsr;
	srand(time(NULL));
	for ($i = 0; $i < 100; $i++)
	{
		$stars[$i] = array(
			((rand() % 320)+1 - 160) * 3,
			((rand() % 320)+1 - 160) * 3,
			((rand() % 128)+1 - 64) * 5
		);
		$starsr[$i] = $stars[$i];
	}
}

function InitGraphics($video_flags) 
{
	global $video, $colors, $xoff, $yoff;

	if (SDL_Init(SDL_INIT_VIDEO) < 0) {
		exit;
	}

	$video = SDL_SetVideoMode(640, 480, 16, $video_flags);
	if(!$video) {
		exit;
	}
	
	printf("Set %dx%dx%d video mode\n", $video['w'], $video['h'], $video['format']['BitsPerPixel']);
	$xoff = $video['w']/2;
	$yoff = $video['h']/2;

	/* Assuming 8-bit palette */
	if ( $video['format']['palette'] ) {
		for ($i = 0; $i < 256; $i++) {
			$clut[$i]["r"] = $i;
			$clut[$i]["g"] = $i;
			$clut[$i]["b"] = $i;
		}
		SDL_SetColors($video, $clut, 0, 256);
	}
	for ($i = 0; $i < 256; $i++) {
		$colors[$i] = SDL_MapRGB($video['format'], $i, 255, 255);
	}

	/* We ignore all but keyboard events */
	for ( $i = 0; $i<SDL_NUMEVENTS; ++$i ) {
		if ( ($i != SDL_KEYDOWN) && ($i != SDL_QUIT) ) {
			SDL_EventState($i, SDL_IGNORE);
		}
	}
}

