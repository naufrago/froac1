<?php

class Z extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    
    public function index(){
        $this->load->view('usr/z_view');
    }
    
    

}
?>
