<?php

class Repo_ent_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertar_repo($user) {
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
            "lastupdate" => $today,
            "countoas" => 0,
            "repouser" => $user
        );
        $this->db->insert('repository', $data);
    }

    public function insertar_repo_roap($user) {
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
            "lastupdate" => $today,
            "countoas" => 0,
            "repouser" => $user
        );
        $this->db->insert('repository', $data);
    }

    public function get_repo($user) {
        $query = $this->db->get_where('repository', array('repouser' => $user));
//        $query = $this->db->get_where('repository',array('repouser' => $user));
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

    public function get_most_downloaded($idrepository) {
        $this->db->select('lom_tittle, count(*)');
        $this->db->from('lom_history');
        $this->db->where('idrepository', $idrepository);
        $this->db->limit('10');
        $this->db->group_by('lom_tittle');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function num_repos($user){
       $this->db->select('count(idrepository) as numero');
       $this->db->from('repository');
       $this->db->where('repouser',$user);
       $query = $this->db->get();
       return $query->result_array();
       
   }
   public function nom_repos($user){
       $this->db->select('idrepository,name');
       $this->db->from('repository');
       $this->db->where('repouser',$user);
       $query = $this->db->get();
       return $query->result_array();
   }
   
   public function get_user_repo_mod($user){
       $this->db->select('nombre,apellido,username,email');
       $this->db->from('usuarios');
       $this->db->where('username',$user);
       $query = $this->db->get();
       return $query->result_array();
       
   }
   
   public function veryfied_user($username,$contrasenaactual){
       $this->db->select('username');
       $this->db->from("usuarios");
       $this->db->where("username",$username);
       $this->db->where("clave",  md5($contrasenaactual));
       $query = $this->db->get();
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

}

?>
