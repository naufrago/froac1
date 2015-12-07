<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Init_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lom_model');
        $this->load->model('usuario_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $data = array(
                'username' => $session_data['username'],
                "rol" => $rol[0]['rol'],
                "title" => "Inicio",
                "main" => "usr/init_view",
            );
            $this->load->view('include/u_template2_1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function acercade() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $data = array(
                'username' => $session_data['username'],
                "rol" => $rol[0]['rol'],
                "title" => "Acerca de",
                "main" => "usr/acerca_view"
            );
            $this->load->view('include/u_template1_1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function equipo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $data = array(
                'username' => $session_data['username'],
                "rol" => $rol[0]['rol'],
                "title" => "Equipo",
                "main" => "usr/equipo_view"
            );
            $this->load->view('include/u_template1_1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function glosario() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $data = array(
                'username' => $session_data['username'],
                "rol" => $rol[0]['rol'],
                "title" => "Glosario",
                "main" => "usr/glosario_view"
            );
            $this->load->view('include/u_template1_1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function build() {
        $session_data = $this->session->userdata('logged_in');
        $rol = $this->usuario_model->get_rol_user($session_data['username']);

        $content = array(
            'username' => $session_data['username'],
            "rol" => $rol[0]['rol'],
            "title" => "En Construcción",
            "main" => "usr/build_view"
        );
        $this->load->view('include/u_template1_1', $content);
    }

    public function evaluation_expert() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $pregunta1 = $this->input->get('preguntaex1');
            $pregunta2 = $this->input->get('preguntaex2');
            $pregunta3 = $this->input->get('preguntaex3');
            $pregunta4 = $this->input->get('preguntaex4');
            $pregunta5 = $this->input->get('preguntaex5');
            $pregunta6 = $this->input->get('preguntaex6');
            $pregunta7 = $this->input->get('preguntaex7');
            $pregunta8 = $this->input->get('preguntaex8');
            $pregunta9 = $this->input->get('preguntaex9');
            $pregunta10 = $this->input->get('preguntaex10');
            $pregunta11 = $this->input->get('preguntaex11');
            $pregunta12 = $this->input->get('preguntaex12');
            $pregunta13 = $this->input->get('preguntaex13');
            $pregunta14 = $this->input->get('preguntaex14');
            $id_repository = $this->input->get('id_repository');
            $id_lom = $this->input->get('id_lom');
            $dimensionne1 = $this->input->get('ratedimedu');
            $dimensionne2 = $this->input->get('ratedimcont');
            $dimensionne3 = $this->input->get('ratedimeste');
            $dimensionne4 = $this->input->get('ratedimfunc');
            $dimensionne5 = $this->input->get('ratedimmeta');
            $data = array(
                'id_repository' => $id_repository,
                'id_lom' => $id_lom,
                'question_e11' => $pregunta1,
                'question_e12' => $pregunta2,
                'question_e21' => $pregunta3,
                'question_e22' => $pregunta4,
                'question_e31' => $pregunta5,
                'question_e32' => $pregunta6,
                'question_e41' => $pregunta7,
                'question_e42' => $pregunta8,
                'question_e51' => $pregunta9,
                'question_e52' => $pregunta10,
                'question_e61' => $pregunta11,
                'question_e62' => $pregunta12,
                'question_e71' => $pregunta13,
                'question_e81' => $pregunta14,
                'dimension_ne1' => $dimensionne1,
                'dimension_ne2' => $dimensionne2,
                'dimension_ne3' => $dimensionne3,
                'dimension_ne4' => $dimensionne4,
                'dimension_ne5' => $dimensionne5,
                'username' => $session_data['username']
            );

            $this->usuario_model->insert_evaluation_expert($data);
        } else {
            redirect('init', 'refresh');
        }
    }

    public function roas() {
        if ($this->session->userdata('logged_in')) {

            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $content = array(
                'username' => $session_data['username'],
                "rol" => $rol[0]['rol'],
                "title" => "Repositorios Federados",
                "main" => "usr/lista_roas_view1",
                "roas" => $this->usuario_model->get_roas()
            );
            $this->load->view('include/u_template1_1', $content);
        }
    }

    public function usr() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $content = array(
                'username' => $session_data['username'],
                "limit1" => "10",
                "limit2" => "0",
                "title" => "OA'S",
                "rol" => $rol[0]['rol'],
                "main" => "usr/oas_view",
                "cant" => $this->lom_model->cantidad(),
                "cal" => $this->usuario_model->get_cal($session_data['username']),
                "label" => 'N'
            );
            $this->load->view('include/u_template1_1', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

}
