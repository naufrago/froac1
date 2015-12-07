<?php

class Oas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lom_model');
        $this->load->model('usuario_model');
    }

    public function index() {
        $content = array(
            "limit1" => "10",
            "limit2" => "0",
            "title" => "OA'S",
            "rol" => 1,
            "label" => "N",
            "main" => "usr/oas_view"
        );
        $this->load->view('include/u_template1', $content);
    }

    public function usr() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');

            $content = array(
                'username' => $session_data['username'],
                "limit1" => "10",
                "limit2" => "0",
                "title" => "OA'S",
                "rol" => 1,
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

    public function oasg($limit1, $limit2) {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            $content = array(
                'username' => $session_data['username'],
                "lom" => $this->lom_model->get_list_lom($limit1, $limit2),
                "rol" => $rol[0]['rol'],
                "keyword" => $this->lom_model->get_a_keyword()
            );
            $this->load->view('usr/oasg_view', $content);
        } else {
            $content = array(
                "lom" => $this->lom_model->get_list_lom($limit1, $limit2),
                "rol" => 1,
                "keyword" => $this->lom_model->get_a_keyword()
            );
            $this->load->view('usr/oasg_view', $content);
        }
    }

    public function oasr($id_rep, $limit1, $limit2) {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'username' => $session_data['username'],
                "lom" => $this->lom_model->get_list_lom_r($id_rep, $limit1, $limit2),
                "rol" => 1,
                "keyword" => $this->lom_model->get_a_keyword()
            );
            $this->load->view('usr/oasg_view', $content);
        } else {
            $content = array(
                "lom" => $this->lom_model->get_list_lom_r($id_rep, $limit1, $limit2),
                "rol" => 1,
                "keyword" => $this->lom_model->get_a_keyword()
            );
            $this->load->view('usr/oasg_view', $content);
        }
    }

    public function total_reg($limit1, $limit2) {

        $total = $this->lom_model->total($limit1, $limit2);

        echo $total;
    }

    public function total_reg_r($id_rep, $limit1, $limit2) {

        $total = $this->lom_model->total($limit1, $limit2);

        echo $total;
    }

    public function oas_repo($id_repo) {
        $content = array(
            "limit1" => "10",
            "limit2" => "0",
            "title" => "OA'S",
            "label" => "R",
            "rol" => 1,
            "main" => "usr/oas_view",
            "id_rep" => $id_repo
        );
        $this->load->view('include/u_template1', $content);
    }

    public function ver_objeto() {

        $content = array(
            "title" => "Glosario",
            "main" => "usr/objeto_view",
            "url" => $_GET['url']
        );
        $this->load->view('include/u_template1', $content);
    }

}

?>
