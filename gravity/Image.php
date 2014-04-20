<?php

class Image
{
	protected $surface;

	public function getSurface()
	{
		return $this->surface;
	}

	public function __destruct()
	{
		SDL_FreeSurface( $this->surface );
	}
}

class BmpImage extends Image
{
	public function __construct( $path )
	{
		$this->surface = SDL_LoadBMP( $path );
		if( null === $this->surface )
		{
			throw new Exception( SDL_GetError() );
		}
	}
}

