<?php

class Fps
{
	private $t;
	private $tl;
	private $tpl;

	public function __construct( $frames_per_second )
	{
		$this->tl = $this->t = SDL_GetTicks();
		$this->tpl = 1000 / $frames_per_second;
	}

	public function update()
	{
		$this->t = SDL_GetTicks();
		if( ( $this->t - $this->tl ) > $this->tpl )
		{
			$rep = ($this->t - $this->tl) / $this->tpl;
			$this->tl += $rep * $this->tpl;
			return $rep;
		}
		else
		{
			SDL_Delay($this->tpl - ($this->t - $this->tl));
			return 0;
		}
	}
}

