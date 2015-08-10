<?php

use Phalcon\Mvc\Model;

class Type extends Model
{
	public function initialize()
	{
		$this->setSource("types");
	}
}