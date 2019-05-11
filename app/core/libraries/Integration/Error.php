<?php
namespace Rimbun\Integration;
defined('BASEPATH') OR exit('No direct script access allowed');

class Error
{
	function add_error($library,$message)
	{
		show_error($message,500,$library);
	}
}