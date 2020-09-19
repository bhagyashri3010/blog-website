<?php
if(isset($header) && $header)
	$this->load->view('user/header',$active);

if(isset($sidebar) && $sidebar)
	$this->load->view('user/sidebar');

if(isset($_view) && $_view)
	$this->load->view($_view);

if(isset($footer) && $footer)
	$this->load->view('user/footer');

?>