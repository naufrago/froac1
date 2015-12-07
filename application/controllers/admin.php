<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'user' => $session_data['username'],
                'main' => 'adm/lista_repo_view',
                'titulo' => 'Inicio | Admin',
                'title' => 'Inicio | Admin',
                "page" => "Inicio",
            );
             $this->load->view('include/adm_template_froac', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

}

?>
