<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader 
{
	public function __construct()
	{
		$this->_ci_ob_level  = ob_get_level();
		$this->_ci_library_paths = array(APPPATH, BASEPATH);
		$this->_ci_helper_paths = array(APPPATH, BASEPATH);
		$this->_ci_model_paths = array(APPPATH2);
		$this->_ci_view_paths = array(APPPATH2 . 'views/'	=> TRUE);
		
		log_message('debug', "Loader Class Initialized");
	}
	

	public function re_view_path()
	{
		$this->_ci_view_paths = array(APPPATH2 . 'views/'	=> TRUE);
		return $this;
	}
	

	// 设置view路径
	public function set_view_path($path, $app='')
	{
		if($app != '')
		{
			$this->_ci_view_paths = array('app_'. $app .'/'. $path .'/views/'	=> TRUE);
		}
		else
		{
			$this->_ci_view_paths = array(APP . $path.'/views/'	=> TRUE);

		}
		return $this;
	}
	

	// 设置model路径
	public function set_model_path($path, $app='')
	{
		if($app != '')
		{
			$this->_ci_model_paths = array('app_'. $app .'/'. $path .'/');
		}
		else
		{
			$this->_ci_model_paths = array(APP . $path .'/');
		}
		
		return $this;
	}
	
}