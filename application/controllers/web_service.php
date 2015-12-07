<?php

class Web_service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lom_model');
    }

    public function index() {
        $content = array(
            "title" => "Web Service",
            'main' => 'usr/web_service_view');
        $this->load->view('include/web_s_template', $content);
    }

    public function busqueda_service() {
        $busqueda = $this->input->post('webusqueda');
        $content = array(
            "title" => "Busqueda Web Service",
            'main' => 'usr/web_service_busqueda_view',
            'busqueda' => $busqueda
        );
        $this->load->view('include/u_template2', $content);
    }

}

?>
