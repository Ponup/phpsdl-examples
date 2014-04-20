<?php

class Engine
{
	public function __construct()
	{

	}

	public function init()
	{
		if( SDL_Init( SDL_INIT_VIDEO ) === -1 )
		{
			throw new Exception( SDL_GetError() );
		}
	}

	public function destroy()
	{
		SDL_Quit();
	}
}

