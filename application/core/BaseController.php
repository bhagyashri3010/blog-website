<?php 

/**
 * 
 */
class BaseController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata('user_id'))
		{
			// set the user vars
			$this->user['id'] = $this->session->userdata('user_id');
			$this->user['name'] = $this->session->userdata('name');
		}
	}


	function is_logged_in()
	{
		if ($this->user['id'])
			return TRUE;
		else
			return FALSE;
	}

	function authenticate()
	{
		if (!$this->is_logged_in())
		{
			redirect('user/login');
			exit;
		}
	}
}