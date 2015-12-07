<?php

//if (!defined('BASEPATH'))
//    exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Adm_ent_repo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('repo_ent_model');
    }

    public function index() {

        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');

            $data = array(
                'username' => $session_data['username'],
                "title" => "Usuario",
                "user" => $session_data['username'],
                "titulo" => "Administrador",
                "main" => "adm_ent/lista_repo_view",
                "page" => "Inicio",
                "repos" => $this->repo_ent_model->get_repo($session_data['username'])
            );

            $this->load->view('include/adm_ent_template1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function registrar_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                "title" => "Registro Repositorios",
                "titulo" => "Usuario",
                "user" => $session_data['username'],
                "main" => "adm_ent/registro_repo_view",
                "page" => "Registro"
            );

            $this->load->view('include/adm_ent_template1', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function insert_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            if ($this->input->post('tiporepositorio') == "roap") {
                $this->repo_ent_model->insertar_repo_roap($session_data['username']);
            } else {
                $this->repo_ent_model->insertar_repo($session_data['username']);
            }

            $this->lista_repo();
        }
    }

    public function lista_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                "title" => "Lista Repositorios",
                "titulo" => "Usuario",
                "user" => $session_data['username'],
                "main" => "adm_ent/lista_repo_view",
                "page" => "Registro",
                "repos" => $this->repo_ent_model->get_repo($session_data['username']),
            );
            $this->load->view('include/adm_ent_template1', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function modificar_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'username' => $session_data['username'],
                "title" => "Modificar Repositorio",
                "titulo" => "Usuario",
                "user" => $session_data['username'],
                "main" => "adm_ent/modificar_repo_view",
                "page" => "Modificación",
                "repomod" => $this->repo_ent_model->get_repo_mod(),
                "usuario" => $this->repo_ent_model->get_user_repo()
            );
            $this->load->view('include/adm_ent_template1', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function graficos() {
        if ($this->session->userdata('logged_in')) {
            
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function reportes_estadisticas() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'username' => $session_data['username'],
                "title" => "Usuario",
                "titulo" => "Administrador",
                "user" => $session_data['username'],
                "main" => "adm_ent/reporte_estadisticas_view",
                "page" => "Reportes y Estadisticas",
                "num_repos" => $this->repo_ent_model->num_repos($session_data['username']),
                "nom_repos" => $this->repo_ent_model->nom_repos($session_data['username'])
            );
            $this->load->view('include/adm_ent_template1', $data);
        } else {
            redirect('init', 'refresh');
        }
    }

    public function modificar_info() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $user = $session_data['username'];            
            $data = array(
                'username' => $session_data['username'],
                "title" => "Lista Usuarios Repositorios",
                "titulo" => "Usuario",
                "user" => $session_data['username'],
                "main" => "adm_ent/modificar_info_view",
                "page" => "Modificar Usuario Repositorio",
                "usuariorepos" => $this->repo_ent_model->get_user_repo_mod($user)
            );

            $this->load->view('include/adm_ent_template1', $data);
        } else {
            redirect('init', 'refresh');
        }
    }

    public function update_user_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $nombre = $this->input->post('nombre');
            $apellido = $this->input->post('apellido');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $contrasenaactual = $this->input->post('contrasenaac');
            $verificar = $this->repo_ent_model->veryfied_user($session_data['username'],$contrasenaactual);
            if(!$verificar){
                http_response_code(500);
//                
            }
            else{
                $this->repo_ent_model->update_user_repo($nombre, $apellido, $username, $password, $email);
                
            }
            
        } else {
            redirect('init', 'refresh');
        }
    }

}
?>


