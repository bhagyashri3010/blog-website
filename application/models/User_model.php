<?php

/*
 *
 *
 */
class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function login($email, $password)
	{
		$admin = $this->db->get_where('users',array('email'=>$email, 'password' => $password))->row_array();
		if(isset($admin['id']))
		{
			$session = array(
				'user_id' => $admin['id'],
				'name' => $admin['first_name'].' '.$admin['last_name']
				);
			$this->session->set_userdata($session);

			$response['rc'] = TRUE;
			$response['msg'] = 'Successful login';
		} else {
			$response['rc'] = FALSE;
			$response['msg'] = 'Invalid email and password';
		}
		return $response;
	}
}