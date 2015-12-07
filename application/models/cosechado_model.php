<?php

class Cosechado_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_repo_mod() {
        $id = $this->input->post('idrepository');
        $query = $this->db->get_where('repository', array('idrepository' => $id));
        return $query->result_array();
    }
    
    public function get_user_repo() {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->or_where('rol', '1');
        $this->db->or_where('rol', '6');
        $query = $this->db->get();
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
    
    public function get_roas_oai(){
        $query = $this->db->get_where('repository',array('typerepository' =>'OAI'));
        return $query->result_array();
    }
}
?>
