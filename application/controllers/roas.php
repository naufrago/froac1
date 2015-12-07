<?php

class Roas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function index() {

        $content = array(
            "title" => "Repositorios Federados",
            "main" => "usr/lista_roas_view1",
            "roas" => $this->usuario_model->get_roas()
        );
        $this->load->view('include/u_template1', $content);
    }

}

?>
