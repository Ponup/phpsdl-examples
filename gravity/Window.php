<?php

class Window
{
	private $res;

	private $title;

	private $icon;

	public function __construct()
	{
		$this->res = SDL_SetVideoMode( 320, 240, 16, SDL_DOUBLEBUF | SDL_HWSURFACE );
		if( null === $this->res )
		{
			throw new Exception( SDL_GetError() );
		}

		$this->title = '';
		$this->icon = null;
	}

	public function setTitle( $title )
	{
		$this->title = $title;
		$this->updateTitleIcon();
	}

	private function updateTitleIcon()
	{
		SDL_WM_SetCaption( $this->title, $this->icon );
	}

	public function update()
	{
		SDL_Flip( $this->res );
	}

	public function getSurface()
	{
		return $this->res;
	}
}

