<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_URI extends CI_URI 
{
	public function url_domain()
	{
		return $_SERVER['HTTP_HOST'];
	}
	
	public function url_path()
	{
		return $_SERVER['PHP_SELF'];
	}
	

	public function url_query_string()
	{
		return $_SERVER["QUERY_STRING"];
	}
	
	public function url_str()
	{
		return $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}
}