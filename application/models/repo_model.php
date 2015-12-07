<?php

class Repo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertar_repo() {
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

    public function insertar_repo_roap() {
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

    public function get_graficos($idrepository) {
        $this->db->select('*');
        $this->db->from('repository_history');
        $this->db->where('idrepository', $idrepository);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_most_downloaded() {
        $this->db->select('lom_tittle, count(*)');
        $this->db->from('lom_history');        
        $this->db->limit('10');
        $this->db->group_by('lom_tittle');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_downloaded_repository($idrepository) {
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

    public function get_roas_oai() {
        $query = $this->db->get_where('repository', array('typerepository' => 'OAI'));
        return $query->result_array();
    }
    
    public function get_users_repos(){
        $query = $this->db->get_where('usuarios',array('rol' => 6));
        return $query->result_array();
    }
    
    public function get_user_repo_mod($user,$rol){
        $query = $this->db->get_where('usuarios', array('username' => $user, 'rol' =>(int)$rol));
        return $query->result_array();
    }
    
    public function update_user_repo($nombre,$apellido,$username,$password,$email){
        $valores = array(
            "nombre" => $nombre,
            "apellido" => $apellido,
            "username" => $username,
            "clave" => md5($password),
            "email" => $email
        );
        $this->db->where("username",$username);
        $this->db->update('usuarios',$valores);
    }
    
    public function get_users_froac(){
        $query = $this->db->query("select usuarios.nombre,usuarios.apellido, usr_rol.nombre_rol, usuarios.username,usuarios.email,usuarios.fecha_registro 
from usuarios,usr_rol where usuarios.rol=usr_rol.id_rol");
        return $query->result_array();
    }
    
    public function add_new_user_repo($nombre,$apellido,$username,$email,$password,$fecha_inscripcion,$rol){
        $datos = array(
            "nombre" => $nombre,
            "apellido" => $apellido,
            "rol" => $rol,
            "username" => $username,
            "clave" => $password,
            "email" => $email,
            "fecha_registro" => $fecha_inscripcion            
        );
        $this->db->insert("usuarios",$datos);
    }

}

?>
