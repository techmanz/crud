<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 22.12.2014
 * Time: 21:27
 */

class H
{
	static function v($val, $exit = 1)
	{
		echo '<pre>';
		print_r($val);
		echo '</pre>';

		if ($exit) exit();
	}

	static function vd($val, $exit = 1)
	{
		echo '<pre>';
		var_dump($val);
		echo '</pre>';

		if ($exit) exit();
	}

	static function b($bool, $exit = 1)
	{
		echo '<pre>';
		echo (bool)$bool ? "TRUE\n" : "FALSE\n";
		echo '</pre>';
		if ($exit) exit();
	}
}