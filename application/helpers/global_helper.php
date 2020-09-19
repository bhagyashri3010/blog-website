<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function dd()
{
	foreach (func_get_args() as $key) 
	{
		echo '<pre>';
		print_r($key);
		echo '</pre>'.PHP_EOL;
	}
	exit;
}