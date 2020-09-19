<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class User extends BaseController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('User_model', 'Blog_model', 'Category_Model'));
	}

	function index()
	{
		redirect('blog/frontend');
	}

	function login()
	{
		/*$array = array('username' => 'admin', 'password' => md5('aaaaaa'));
		$this->db->insert('users', $array);*/

		$this->form_validation->set_rules('email','Email','required|valid_email|trim');
		$this->form_validation->set_rules('password','Password','required|xss_clean|trim|MD5');

		if ($this->form_validation->run() == FALSE)
		{
			//pass the partial views
			$data["header"] = FALSE;
			$data["footer"] = FALSE;
			$data["_view"] = "user/login";
			$data['title'] = "My Blog Website | Login";
			$this->load->view("user/basetemplate", $data);
		}
		else
		{
			$email		= $this->input->post('email');
			$password	= $this->input->post('password');

			$response = $this->User_model->login($email,$password);

			if($response['rc'])
			{
				redirect('dashboard');
			}
			else
			{
				$this->session->set_flashdata('error_msg', $response['msg']);
				redirect('login');
			}
		}
	}

	function dashboard()
	{
		$this->authenticate();

		$data['blog_count'] = $this->Blog_model->get_all_blogs(array(), TRUE);
		$data['category_count'] = $this->Category_Model->get_all_categories(array(), TRUE);

		//pass the partial views
		$data["sidebar"]	= TRUE;
		$data["header"]		= TRUE;
		$data["footer"]		= TRUE;
		$data['title']		= "My Blog Website | Dashboard";
		$data["active"]		= "dashboard";
		$data["_view"]		= "user/dashboard";
		$this->load->view("user/basetemplate", $data);
	}

	function logout()
	{
		if($this->is_logged_in())
		{
			$this->session->sess_destroy();
		}
		redirect('login');
	}
}