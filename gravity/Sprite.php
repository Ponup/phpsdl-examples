<?php

class Sprite
{
	private $frames;
	private $currentFrameNum;
	private $transparentColor;

	public function __construct( Color $transparentColor = null )
	{
		$this->currentFrameNum = 0;
		$this->frames = array();
		$this->transparentColor = $transparentColor;
	}

	public function addFrame( $path )
	{
		$image = sdl_loadbmp( $path );

		if( null !== $this->transparentColor )
		{
			$color = SDL_MapRGB( $image['format'],
				$this->transparentColor->getRed(),
				$this->transparentColor->getGreen(),
				$this->transparentColor->getBlue()
			);
			SDL_SetColorKey( $image, SDL_SRCCOLORKEY, $color );
		}

		if( null !== $image )
		{
			$this->frames[] = $image;
		}
	}

	public function draw( $surface, array $dest )
	{
		SDL_BlitSurface( $this->frames[ $this->currentFrameNum++ ], null, $surface, $dest );
		if( $this->currentFrameNum > count( $this->frames ) - 1  )
		{
			$this->currentFrameNum = 0;
		}
	}

	public function __destruct()
	{
		foreach( $this->frames as $frame )
		{
			sdl_freesurface( $frame );
		}

		unset( $this->frames );
	}
}


