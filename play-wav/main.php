<?php
/**
 * Example of how to load a WAV file and play it using the PHP-SDL extension.
 *
 * @author Santiago Lizardo <santiagolizardo@php.net>
 */

require '../common.php';

SDL_Init( SDL_INIT_AUDIO );

$desired = array(
	'freq' => 22050,
	'format' => AUDIO_S16LSB,
	'channels' => 2, // Stereo
	'samples' => 4096,
);
$obtained = null;

if( -1 === SDL_OpenAudio( $desired, $obtained ) )
{
	fprintf( STDERR, 'Could not open audio %s' . PHP_EOL, SDL_GetError() );
}

$wavSpec = $wavBuffer = $wavLength = null;
$wav = SDL_LoadWAV( 'claxon.wav', $wavSpec, $wavBuffer, $wavLength );
if( null === $wav )
{
	fprintf( STDERR, 'Could not open the WAV file: %s' . PHP_EOL, SDL_GetError() );
}

SDL_PauseAudio( 0 );

while( SDL_AUDIO_PLAYING === SDL_GetAudioStatus() )
{
	SDL_Delay( 450 );
}

SDL_FreeWav( $wavBuffer );

SDL_CloseAudio();

