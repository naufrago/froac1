<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eval_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('eval_model');
    }

    public function insertar_consistencia() {
        $today = date("Y-m-d");
        $data = array(
            "host" => $this->input->post('host'),
            "port" => $this->input->post('puerto'),
            "databasename" => $this->input->post('basededatos'),
            "loggin" => $this->input->post('usuario'),
            "password" => $this->input->post('contrasena'),
            "affiliation" => $this->input->post('entidad'),
            "registrationdate" => $today,
            "url" => $this->input->post('url'),
            "typerepository" => $this->input->post('tiporepositorio'),
            "email" => $this->input->post('email'),
            "name" => $this->input->post('nombrerepositorio'),
            "metadata_inf" => $this->input->post('metadata'),
            "frequency" => $this->input->post('periodicidad'),
            "countoas" => 0,
            "repouser" => $this->input->post('usuariorepo')
        );
        $this->db->insert('repository', $data);
    }

    public function insertar_coherencia() {
        $today = date("Y-m-d");
        $data = array(
            "host" => $this->input->post('host'),
            "port" => $this->input->post('puerto'),
            "databasename" => $this->input->post('basededatos'),
            "loggin" => $this->input->post('usuario'),
            "password" => $this->input->post('contrasena'),
            "affiliation" => $this->input->post('entidad'),
            "registrationdate" => $today,
            "url" => $this->input->post('url'),
            "typerepository" => $this->input->post('tiporepositorio'),
            "email" => $this->input->post('email'),
            "name" => $this->input->post('nombrerepositorio'),
            "metadata_inf" => $this->input->post('metadata'),
            "frequency" => 0,
            "countoas" => 0,
            "repouser" => $this->input->post('usuariorepo')
        );
        $this->db->insert('repository', $data);
    }

    public function get_repo() {
        $query = $this->db->get('repository');
        return $query->result_array();
    }

    public function get_repo_mod() {
        $id = $this->input->post('idrepository');
        $query = $this->db->get_where('repository', array('idrepository' => $id));
        return $query->result_array();
    }

    public function modificar_repo() {
        $today = date("Y-m-d");
        $data = array(
            "host" => $this->input->post('host'),
            "port" => $this->input->post('puerto'),
            "databasename" => $this->input->post('basededatos'),
            "loggin" => $this->input->post('usuario'),
            "password" => $this->input->post('contrasena'),
            "affiliation" => $this->input->post('entidad'),
            "registrationdate" => $this->input->post('registrationdate'),
            "url" => $this->input->post('url'),
            "typerepository" => $this->input->post('tiporepositorio'),
            "email" => $this->input->post('email'),
            "name" => $this->input->post('nombrerepositorio'),
            "metadata_inf" => $this->input->post('metadata'),
            "frequency" => $this->input->post('periodicidad'),
            "lastupdate" => $today,
            "countoas" => $this->input->post('countoas'),
            "repouser" => $this->input->post('usuariorepo')
        );
        $this->db->where('idrepository', intval($this->input->post('idrepository')));
        $this->db->update('repository', $data);
    }

    public function get_id_lo($idrepository, $idlom) {

        $this->db->select('count(*)');
        $this->db->from('lo');
        $this->db->where('idrepository', $idrepository);
        $this->db->where('idlom', $idlom);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $data = $row->count;
        }
        return $data;
    }

    public function get_cant_oas_repo($idrepository) {
        $this->db->select('count(*)');
        $this->db->from('lom');
        $this->db->where('idrepository', $idrepository);
        $query = $this->db->get();
        $res = $query->result();
        foreach ($res as $key) {
            $val = $key->count;
        }
        return $val;
    }

    public function get_lo($idrepository, $idlom) {

        $this->db->select('idlom, lastmodified');
        $this->db->from('lo');
        $this->db->where('idrepository', $idrepository);
        $this->db->where('idlom', $idlom);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_table($data, $tabla) {
        $this->db->insert($tabla, $data);
    }

    public function update_table($data, $tabla, $campos, $valores) {

        $size = sizeof($campos);
        for ($i = 0; $i < $size; $i++) {
            $this->db->where($campos[$i], $valores[$i]);
        }
        $this->db->update($tabla, $data);
    }

    public function delete_table($tabla, $campos, $valores) {

        $size = sizeof($campos);
        for ($i = 0; $i < $size; $i++) {
            $this->db->where($campos[$i], $valores[$i]);
        }
        $this->db->delete($tabla);
    }

    public function get_user_repo() {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->or_where('rol', '1');
        $this->db->or_where('rol', '6');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_rss_feeds() {
        $query = $this->db->query('select rss.idnotice, repository.name, rss.notice_title from rss, repository where repository.idrepository=rss.idrepository');
        return $query->result_array();
    }

    public function get_oas($search) {
        $query = $this->db->query("select repository.name, repository.idrepository, lom.general_title,rss.notice_title,technical_location.location from lom  
inner join lo ON lo.idlom=lom.idlom inner join technical_location on technical_location.idlom=lom.idlom 
inner join repository on repository.idrepository=lom.idrepository 
inner join rss on rss.idrepository=lom.idrepository 
where  repository.idrepository=lom.idrepository and rss.idnotice='" . $search . "' limit 10");
        return $query->result_array();
    }

    public function get_graficos($idrepository) {
        $this->db->select('*');
        $this->db->from('repository_history');
        $this->db->where('idrepository', $idrepository);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_most_downloaded($idrepository) {
        $this->db->select('lom_tittle, count(*)');
        $this->db->from('lom_history');
        $this->db->where('idrepository', $idrepository);
        $this->db->limit('10');
        $this->db->group_by('lom_tittle');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function num_repos() {
        $this->db->select('count(idrepository) as numero');
        $this->db->from('repository');

        $query = $this->db->get();
        return $query->result_array();
    }   

    public function nom_repos() {
        $this->db->select('idrepository,name');
        $this->db->from('repository');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function grafico_perso($idrepository, $fechainicio, $fechafin) {
        $query = $this->db->query("select * from repository_history where idrepository='" . $idrepository . "'and  fecha between '" . $fechainicio . "' and '" . $fechafin . "'");
        return $query->result_array();
    }
    
    public function get_roas_oai(){
        $query = $this->db->get_where('repository',array('typerepository' =>'OAI'));
        return $query->result_array();
    }
}

?>
