<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Category extends BaseController
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Category_model');
	}

	function listing()
	{
		$this->authenticate();

		$this->load->library('pagination');

		$params = array();

		if ($this->input->get('search_term') && $this->input->get('search_term') != "") {
			$params['searchterm'] = $this->input->get('search_term');
		}
		// Get all categories
		$categories = $this->Category_model->get_all_categories($params, TRUE);

		// config pagination
		$config = array();
		$config["base_url"] 		= site_url("category/listing");
		$config["total_rows"] 		= $categories['rc'] ? $categories['data'] : 0 ;
		$config["per_page"] 		= ITEMS_PER_PAGE;
		$config["uri_segment"] 		= 3;

		$config['num_links'] 		= 3;
		$config['first_link'] 		= '<i class="fa fa-angle-double-left"></i>';
		$config['last_link']  		= '<i class="fa fa-angle-double-right"></i>';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close']  = '</li>';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close']  	= '</li>';
		$config['prev_link'] 		= '<i class="fa fa-angle-left"></i>';
		$config['next_link'] 		= '<i class="fa fa-angle-right"></i>';
		$config['full_tag_open'] 	= '<ul class="pagination pagination-sm m-t-none m-b-none">';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['full_tag_close'] 	= '</ul>';

		$this->pagination->initialize($config);

		$params['limit'] = ITEMS_PER_PAGE;
		$params['start'] = is_numeric($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$categories = $this->Category_model->get_all_categories($params, FALSE);

		if($categories['rc'])
			$data['categories'] = $categories['data'];
		else
			$data['categories'] = array();

		$data["links"] = $this->pagination->create_links();

		$data["header"] 	= TRUE;
		$data["sidebar"] 	= TRUE;
		$data["footer"] 	= TRUE;
		$data["_view"] 		= "category/listing";
		$data['title'] 		= "Category Listing | My Blog Website";
		$data["active"] 	= "Category";
		$this->load->view("user/basetemplate", $data);
	}

	function add()
	{
		$this->authenticate();

		$this->form_validation->set_rules('name','Name','trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', lang('invalid_data'));
		} else {
			$data = array(
				'name' 		=> $this->input->post('name'),
				'added_on' 	=> date('Y-m-d G:i:s')
			);
			$result = $this->Category_model->add_category($data);
			if ($result['rc'])
				$this->session->set_flashdata('success', $result['msg']);
			else
				$this->session->set_flashdata('error', $result['msg']);
		}
		redirect('category/listing'); exit;
	}

	function edit()
	{
		$this->authenticate();

		$id = $this->input->post('category_id');
		$category_name = $this->input->post('category_name');
		$category = $this->Category_model->get_category($id);

		if( $category['rc']) {
			$update = $this->Category_model->update_category($id, $category_name);

			if($update['rc'])
				$this->session->set_flashdata('success', $update['msg']);
			else
				$this->session->set_flashdata('error', $update['msg']);
		} else {
			$this->session->set_flashdata('error', lang('invalid_data'));
		}
		redirect('category/listing'); exit;
	}
}