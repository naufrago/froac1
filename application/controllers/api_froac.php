<?php
class Api_froac extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('lom_model');
    }
    public function index(){        
       $idlo = $this->input->get('idlo');
	   $repository = $this->input->get('idrepository');
	   $type = $this->input->get('type');	 
		echo $this->lom_model->insert_lo($repository,$idlo,$type);
		
	
    }
}
?>
