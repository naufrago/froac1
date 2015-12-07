<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Init extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lom_model');
    }

    public function index() {
        $content = array(
            "title" => "Inicio",
            "main" => "usr/init_view"
        );
        $this->load->view('include/u_template2', $content);
    }

    public function acercade() {
        $content = array(
            "title" => "Acerca de",
            "main" =>  "usr/acerca_view"
        );
        $this->load->view('include/u_template1', $content);
    }

    public function equipo() {
        $content = array(
            "title" => "Equipo",
            "main" =>  "usr/equipo_view"
        );
        $this->load->view('include/u_template1', $content);     
    }

    public function glosario() {
        $content = array(
            "title" => "Glosario",
            "main" =>  "usr/glosario_view"
        );
        $this->load->view('include/u_template1', $content);     
    }   
    

    public function build() {
        $content = array(
            "title" => "En Construcción",
            "main" => "usr/build_view"
        );
        $this->load->view('include/u_template1', $content);
    }
    
    public function web_service(){
        $content = array(
            "title" => "Información Web Service",
            "main" => "usr/web_service_info"
        );
        $this->load->view('include/u_template1', $content);
    }
}
