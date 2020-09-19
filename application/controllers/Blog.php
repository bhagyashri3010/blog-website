<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Blog extends BaseController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Blog_model','Category_Model'));
	}

	function listing()
	{
		$this->authenticate();

		$this->load->library('pagination');

		$params = array();

		if ($this->input->get('search_term') && $this->input->get('search_term') != "") {
			$params['searchterm'] = $this->input->get('search_term');
		}
		// Get all blogs
		$blogs = $this->Blog_model->get_all_blogs($params, TRUE);

		// config pagination
		$config = array();
		$config["base_url"] 		= site_url("blog/listing");
		$config["total_rows"] 		= $blogs['rc'] ? $blogs['data'] : 0 ;
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

		$blogs = $this->Blog_model->get_all_blogs($params, FALSE);

		if($blogs['rc'])
			$data['blogs'] = $blogs['data'];
		else
			$data['blogs'] = array();

		$data["links"] = $this->pagination->create_links();

		$data["header"] 	= TRUE;
		$data["sidebar"] 	= TRUE;
		$data["footer"] 	= TRUE;
		$data["_view"] 		= "blog/listing";
		$data['title'] 		= "Blogs Listing | My Blog Website";
		$data["active"] 	= "Blogs";
		$this->load->view("user/basetemplate", $data);
	}

	function add()
	{
		$this->authenticate();

		$categories = $this->Category_Model->get_all_categories();
		$data['blog_categories'] = $categories['rc'] ? $categories['data'] : array();

		$this->form_validation->set_rules('title','Title','trim|required|xss_clean');
		$this->form_validation->set_rules('url','URL','trim|required|callback_cleanURL[url]');
		$this->form_validation->set_rules('page_title','Page title','trim|required|xss_clean');
		$this->form_validation->set_rules('blog_category','Blog Category','trim|required|xss_clean');
		$this->form_validation->set_rules('body','Body','trim|required');
		$this->form_validation->set_rules('short_description','Short description','trim|required|xss_clean');
		$this->form_validation->set_rules('image', 'Image', 'callback_required_image|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data["header"] 	= TRUE;
			$data["sidebar"] 	= TRUE;
			$data["footer"] 	= TRUE;
			$data["_view"] 		= "blog/add";
			$data['title'] 		= "Add Blogs | My Blog Website";
			$data["active"] 	= "Blogs";
			$this->load->view("user/basetemplate", $data);
		} else {
			$blog_data = array(
				'title' 			=> $this->input->post('title'),
				'url' 				=> $this->input->post('url'),
				'body'				=> $this->input->post('body'),
				'page_title'		=> $this->input->post('page_title'),
				'short_description'	=> $this->input->post('short_description'),
				'category_id'		=> $this->input->post('blog_category'),
				'added_by' 			=> $this->user['id'],
				'added_on' 			=> date('Y-m-d G:i:s')
			);

			$blog = $this->Blog_model->add_blog($blog_data,$_FILES);

			if ($blog['rc']) {
				$this->session->set_flashdata('success', $blog['msg']);
				redirect('blog/listing');
			} else {
				$this->session->set_flashdata('error', $blog['msg']);
				redirect('blog/listing');
			}
		}
	}

	function edit($id)
	{
		$this->authenticate();

		$blog = $this->Blog_model->get_blog($id);

		$categories = $this->Category_Model->get_all_categories();
		$data['blog_categories'] = $categories['rc'] ? $categories['data'] : array();

		if ($blog['rc']) {

			$this->form_validation->set_rules('title','Title','trim|required|xss_clean');
			$this->form_validation->set_rules('url','URL','trim|required|callback_cleanURL[url]');
			$this->form_validation->set_rules('page_title','Page title','trim|required|xss_clean');
			$this->form_validation->set_rules('blog_category','Blog Category','trim|required|xss_clean');
			$this->form_validation->set_rules('body','Body','trim|required');
			$this->form_validation->set_rules('short_description','Short description','trim|required|xss_clean');
			if( isset($_FILES['image']) ) {
				$this->form_validation->set_rules('image', 'Image', 'callback_required_image|xss_clean');
			}

			if( $this->form_validation->run() )
			{
				$blog_data = array(
					'title' 			=> $this->input->post('title'),
					'url' 				=> $this->input->post('url'),
					'body'				=> $this->input->post('body'),
					'page_title'		=> $this->input->post('page_title'),
					'short_description'	=> $this->input->post('short_description'),
					'category_id'		=> $this->input->post('blog_category'),
					'added_by' 			=> $this->user['id'],
					'modified_on' 		=> date('Y-m-d G:i:s')
				);

				$response = $this->Blog_model->update_blog($id, $blog_data, $_FILES);
				if($response['rc'])
				{
					$this->session->set_flashdata('success', $response['msg']);
					redirect('blog/listing');
				} else {
					$this->session->set_flashdata('error', $response['msg']);
				}
			} else {
				$data['blog']		= $blog['data'];
				$data["header"] 	= TRUE;
				$data["sidebar"] 	= TRUE;
				$data["footer"] 	= TRUE;
				$data["_view"] 		= "blog/edit";
				$data['title'] 		= "Add Blogs | My Blog Website";
				$data["active"] 	= "Blogs";
				$this->load->view("user/basetemplate", $data);
			}
		} else {
			$this->session->set_flashdata("error",'Invalid id');
			redirect('blog/listing');
		}
	}

	function delete_image()
	{
		$blog_id = $this->input->post('blog_id');

		$result = $this->Blog_model->delete_image( $blog_id );

		$msg_type = $result['rc'] ? 'success' : 'error';

		$this->session->set_flashdata( $msg_type, $result['msg'] );
		redirect('blog/edit/' . $blog_id); exit;
	}

	function delete_blog()
	{
		$this->authenticate();

		$id = $this->input->post('blog_id');

		$blog = $this->Blog_model->get_blog($id);

		if( $blog['rc']) {
			$delete_result = $this->Blog_model->delete_blog($id, $blog);

			if($delete_result['rc'])
				$this->session->set_flashdata('success', $delete_result['msg']);
			else
				$this->session->set_flashdata('error', $delete_result['msg']);
		} else {
			$this->session->set_flashdata('error', lang('invalid_data'));
		}

		redirect('blog/listing'); exit;
	}

	function cleanURL($url)
	{
		if($url)
		{
			$url = str_replace("'", '', $url);
			$url = str_replace('%20', ' ', $url);
			$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator
			$url = trim($url, "-");
			$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);  // you may opt for your own custom character map for encoding.
			$url = strtolower($url);
			$url = preg_replace('~[^-a-z0-9_]+~', '', $url); // keep only letters, numbers, '_' and separator
			return $url;
		}
	}

	function required_image()
	{
		$type = $_FILES['image']['type'];
		if(isset($type) && $type != "")
		{
			if($type != "image/jpg" && $type != "image/png" && $type != "image/jpeg" && $type!= "image/gif" )
			{
				$this->form_validation->set_message('required_image','Invalid file type');
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
		else
		{
			$this->form_validation->set_message('required_image','Please upload image');
			return FALSE;
		}
	}

	function frontend_listing()
	{
		$categories = $this->Category_Model->get_all_categories();
		$data['categories'] = $categories['rc'] ? $categories['data'] : array();

		$params = array();
		if (isset($_GET['blog_category'])) {
			$params['blog_category'] = $_GET['blog_category'];
			$data['blog_category'] = $_GET['blog_category'];
		}

		$blogs = $this->Blog_model->get_all_blogs($params, TRUE);
		// config pagination
		$config = array();
		$config["base_url"] 		= site_url("blog/frontend");
		$config["total_rows"] 		= $blogs['rc'] ? $blogs['data'] : 0 ;
		$config["per_page"] 		= 3;
		$config["uri_segment"] 		= 3;
		$config['reuse_query_string'] = TRUE;
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

		$params['limit'] = 3;
		$params['start'] = is_numeric($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$blogs = $this->Blog_model->get_all_blogs($params, FALSE);

		if($blogs['rc'])
			$data['blogs'] = $blogs['data'];
		else
			$data['blogs'] = array();

		$data["links"] = $this->pagination->create_links();

		$data["header"] 	= TRUE;
		$data["footer"] 	= TRUE;
		$data["_view"] 		= "frontend/listing";
		$data['title'] 		= "Blogs Listing | My Blog Website";
		$this->load->view("frontend/basetemplate", $data);
	}

	function view($url)
	{
		$blog = $this->Blog_model->get_blog_by_url( $url);

		if ($blog['rc'])
		{
			$data["blog"] 		= $blog['data'];
			$data["header"] 	= TRUE;
			$data["footer"] 	= TRUE;
			$data["_view"] 		= "frontend/view";
			$data['title'] 		= "My Blog Website";
			$this->load->view("frontend/basetemplate", $data);
		} else {
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: ".site_url('blog/frontend') );
		}
	}
}