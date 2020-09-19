<?php

class Assets {
    
    static public function js($filename = null)
    {
        $file_path = FCPATH . 'resources/' . $filename;
        if(file_exists($file_path) && $filename != null){
				return '<script type="text/javascript" src="'.base_url()."resources/".$filename.'"></script>';
		}
    }
    
    static public function css($filename = null)
    {
        $file_path = FCPATH . 'resources/' . $filename;
        if(file_exists($file_path) && $filename != null){
				return '<link rel="stylesheet" media="all" href="'.base_url()."resources/".$filename.'" />';
		}
    }

	static public function img($filename,$params=array(),$tag=true)
	{
		if($tag == true)
		{
			$params_str = "";
			foreach($params as $key=>$param)
			{
				$params_str .= $key.'="'.$param.'" ';
			}
			return '<img src="'.base_url()."resources/".$filename.'" '.$params_str.' alt="" />';
		}
		else
			return base_url()."resources/img/".$filename;
	}
    
}