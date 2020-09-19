<?php
if(isset($header) && $header)
    $this->load->view('frontend/header');

if(isset($_view) && $_view)
    $this->load->view($_view);

if(isset($footer) && $footer)
    $this->load->view('frontend/footer');

?>