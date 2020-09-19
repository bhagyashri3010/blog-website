<?php

/**
 *
 */
class Category_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_all_categories($params = array(), $getCount = FALSE)
	{
		if ($getCount) {
			$this->db->select('c.id');
		} else {
			$this->db->select("c.*");
		}

		$this->db->from("blog_categories AS c");
		if (isset($params['searchterm'])) {
			$this->db->where(("c.name LIKE '%".$this->db->escape_like_str($params['searchterm'])."%'"));
		}

		if (isset($params['limit']) && isset($params['start'])) {
			$this->db->limit($params["limit"], $params["start"]);
		}

		$query = $this->db->get();
		$categories = $getCount ? $query->num_rows() : $query->result_array();

		if (!empty($categories)) {
			$response["rc"] = TRUE;
			$response["data"] = $categories;
		} else {
			$response["rc"] = FALSE;
			$response["data"] = array();
		}
		return $response;
	}

	function add_category($data)
	{
		$result = $this->db->insert('blog_categories',$data);
		if ($result) {
			$response["rc"] = TRUE;
			$response["msg"] = 'Category added successfully';
		} else {
			$response["rc"] = FALSE;
			$response["msg"] = 'Error while adding category';
		}
		return $response;
	}

	function get_category($id)
	{
		$category = $this->db->get_where('blog_categories', array('id' => $id) )->row_array();
		if (!empty($category)) {
			$response["rc"] = TRUE;
			$response["data"] = $category;
		} else {
			$response["rc"] = TRUE;
			$response["data"] = array();
		}

		return $response;
	}

	function update_category($id, $category_name)
	{
		$this->db->set('name', $category_name);
		$this->db->where('id', $id);
		$result = $this->db->update('blog_categories');
		if($result)
		{
			$response["rc"] = TRUE;
			$response["msg"] = 'Category updated successfully';
		} else {
			$response["rc"] = TRUE;
			$response["msg"] = 'Error while updating category';
		}

		return $response;
	}
}