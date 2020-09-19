<?php

/**
 *
 */
class Blog_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_all_blogs($params = array(), $getCount = FALSE)
	{
		if ($getCount) {
			$this->db->select('b.id');
		} else {
			$this->db->select("b.*");
			$this->db->select("bc.name AS category");
		}

		$this->db->from("blogs AS b");
		$this->db->join("blog_categories AS bc", "bc.id = b.category_id", "left");

		if (isset($params['searchterm'])) {
			$this->db->where(("b.title LIKE '%".$this->db->escape_like_str($params['searchterm'])."%' OR b.body LIKE '%".$this->db->escape_like_str($params['searchterm'])."%'"));
		}

		if (isset($params['blog_category']) && $params['blog_category'] != '') {
			$this->db->where("b.category_id", $params['blog_category']);
		}

		$this->db->group_by("b.id");
		$this->db->order_by("b.added_on", "DESC");

		if (isset($params['limit']) && isset($params['start'])) {
			$this->db->limit($params["limit"], $params["start"]);
		}

		$query = $this->db->get();
		$result = $getCount ? $query->num_rows() : $query->result_array();

		if (!empty($result)) {
			$response["rc"] = TRUE;
			$response["data"] = $result;
		} else {
			$response["rc"] = FALSE;
			$response["data"] = array();
		}

		return $response;
	}

	function add_blog($blog, $image)
	{
		$result = $this->db->insert('blogs',$blog);
		$blog_id = $this->db->insert_id();

		if ($result) {
			if( isset($image['image']['name']) && $image['image']['name'] != "" )
			{
				$dir = FCPATH . "uploads/blogs/images/" . $blog_id . "/";

				if(!is_dir($dir))
				{
					@mkdir($dir, 0777,true);
				}

				$image = $image['image']['tmp_name'];

				$hash = md5(microtime().rand()).".jpg";

				if(move_uploaded_file($image, $dir.$hash))
				{
					$this->db->set('image_hash', $hash);
					$this->db->where('id', $blog_id);
					$this->db->update('blogs');
				}
			}

			$response['id'] 	= $blog_id;
			$response["rc"] 	= TRUE;
			$response["msg"] 	= 'Blog successfully added';
		}
		else
		{
			$response["rc"] 	= FALSE;
			$response["msg"] 	= 'Error adding blog';
		}

		return $response;
	}

	function get_blog($id)
	{
		$this->db->select("
			b.*,
			bc.name AS category
		");
		$this->db->from("blogs AS b");
		$this->db->join("blog_categories AS bc", "bc.id = b.category_id", "left");
		$this->db->where("b.id", $id);
		$blog = $this->db->get()->row_array();

		if (!empty($blog)) {
			$response["rc"] = TRUE;
			$response["data"] = $blog;
		} else {
			$response["rc"] = FALSE;
			$response["data"] = array();
		}

		return $response;
	}

	function delete_image($id)
	{
		$blog = $this->db->get_where('blogs', array('id' => $id) )->row_array();

		if( ! empty($blog) )
		{
			$delete_folder_path = FCPATH . "uploads/blogs/images/".$id."/";
			if (is_dir($delete_folder_path))
			{
				$delete_images = scandir($delete_folder_path);
				foreach ($delete_images as $key => $value)
				{
					if($value != "." && $value != "..")
						unlink($delete_folder_path.$value);
				}
				rmdir($delete_folder_path);
			}

			$this->db->set('image_hash', '');
			$this->db->where('id', $id);
			$this->db->update('blogs', $blog_data );

			$response['rc'] = TRUE;
			$response['msg'] = 'Image deleted successfully';
		} else {
			$response['rc'] = FALSE;
			$response['msg'] = 'Error deleting image';
		}

		return $response;
	}

	function update_blog($id, $blog, $image = array())
	{
		if($this->db->update('blogs', $blog, array('id' => $id)))
		{
			if( isset($image['image']['name']) && $image['image']['name'] != "" )
			{
				$dir = FCPATH . "uploads/blogs/images/" . $id . "/";

				if(!is_dir($dir))
				{
					@mkdir($dir, 0777,true);
				}

				$image = $image['image']['tmp_name'];

				$hash = md5(microtime().rand()).".jpg";

				if(move_uploaded_file($image, $dir.$hash))
				{
					$this->db->set('image_hash', $hash);
					$this->db->where('id', $id);
					$this->db->update('blogs');
				}
			}

			$response["rc"] = TRUE;
			$response["msg"] = 'Blog successfully updated';
		} else {
			$response["rc"] = FALSE;
			$response["msg"] = 'Error updating blog';
		}
		return $response;
	}

	function delete_blog($id, $blog)
	{
		if( $this->db->delete('blogs', array('id' => $id)) )
		{
			$delete_folder_path = FCPATH . "uploads/blogs/images/".$id."/";
			if (is_dir($delete_folder_path))
			{
				$delete_images = scandir($delete_folder_path);
				foreach ($delete_images as $key => $value)
				{
					if($value != "." && $value != "..")
						unlink($delete_folder_path.$value);
				}
				rmdir($delete_folder_path);
			}

			$response['rc'] = TRUE;
			$response['msg'] = 'Blog deleted successfully';
		} else {
			$response['rc'] = FALSE;
			$response['msg'] = 'Error deleting blog';
		}

		return $response;
	}

	function get_blog_by_url($url)
	{
		$this->db->select("b.*, bc.name AS category");
		$this->db->from("blogs AS b");
		$this->db->join("blog_categories AS bc", "bc.id = b.category_id", "left");
		$this->db->where("b.url", $url);
		$query = $this->db->get()->row_array();
		if (!empty($query)) {
			$response['rc'] = TRUE;
			$response['data'] = $query;
		} else {
			$response['rc'] = FALSE;
			$response['data'] = array();
		}
		return $response;
	}
}