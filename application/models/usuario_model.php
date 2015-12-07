<?php

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function guardar_usuario() {

        $data = array(
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'rol' => $this->input->post('password'),
            'username' => $this->input->post('username'),
            'clave' => $this->input->post('passwd'),
            'email' => $this->input->post('email'),
            'fecha_registro' => $this->input->post('password'),
            'estado' => $this->input->post('password')
        );

        // print_r($data);
    }

    public function guardar_estudiante() {

       
        $today = date("Y-m-d");

        $data = array(
            'id_estudiante' => $this->input->post('username'),
            'fecha_nacimiento' => $this->input->post('fecha_nac'),
            'lugar_origen' => '',
            'sexo' => $this->input->post('sexo'),
            'id_estilo_aprendizaje' => $this->input->post('result_test'),
            'grado_educacion' => 0,
        );

        $data2 = array(
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'rol'=>  $this->input->post('tipoU'),
            'username' => $this->input->post('username'),
            'clave' => md5($this->input->post('passwd')),
            'email' => $this->input->post('email'),
            'fecha_registro' => $today,
        );

        $this->db->insert('usuarios', $data2);
        $this->db->insert('usr_estudiante', $data);
    }

    public function get_a_estudiante() {
        $query = $this->db->get('usr_estudiante');
        return $query->result;
    }

    public function get_usuario_est($user) {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('username', $user);
        $this->db->join('usr_estudiante', 'usuarios.username = usr_estudiante.id_estudiante');
        $this->db->join('usr_estilos_aprendizaje', 'usr_estudiante.id_estilo_aprendizaje = usr_estilos_aprendizaje.id_estilo');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_preferencia_est($user) {
        $this->db->select('*');
        $this->db->from('usr_preferencia_estudiante');
        $this->db->where('id_estudiante', $user);
        $this->db->join('usr_preferencias', 'usr_preferencia_estudiante.id_preferencia = usr_preferencias.id_preferencia');
        $query = $this->db->get();
        return $query->result();
    }

    public function editar_estudiante($id) {

        $data = array(
            'id_estudiante' => $this->input->post('id'),
            'fecha_nacimiento' => $this->input->post('fecha_nac'),
            'lugar_origen' => '',
            'sexo' => $this->input->post('sexo'),
            'id_estilo_aprendizaje' => $this->input->post('result_test'),
            'grado_educacion' => 0,
        );

        $data2 = array(
            'iduser' => $this->input->post('id'),
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'rol' => 3,
            'username' => $this->input->post('username'),
            'clave' => md5($this->input->post('passwd')),
            'email' => $this->input->post('email'),
            'fecha_registro' => $today,
        );
        $this->db->where('id_estudiante', $id);
        $this->db->update('usr_estudiante', $data);
        $this->db->where('iduser', $id);
        $this->db->update('usuarios', $data2);
    }

    public function insert_pref($pref, $id) {

        $data = array(
            'id_preferencia' => $pref,
            'id_estudiante' => $id
        );
        $this->db->insert('usr_preferencia_estudiante', $data);
    }

    public function update_preferencia() {

        $pref = $this->input->post('pref');
        $id = $this->input->post('username');
        $this->db->where('id_estudiante', $id);
        $this->db->delete('usr_preferencia_estudiante');

        foreach ($pref as $key => $value) {
            $this->insert_pref($value, $id);
        }
    }

    public function get_preferencias() {
        $query = $this->db->get('usr_preferencias');

        return $query->result();
    }

    public function get_rol_usr($username) {
        $this->db->select('rol');
        $query = $this->db->get_where('usuarios', array('username' => $username));
        return $query->result_array();
    }

    function login($username, $password) {
        $this->db->select('username, clave');
        $this->db->from('usuarios');
        $this->db->where('username', $username);
        $this->db->where('clave', MD5($password));
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function guardar_calificacion($datos) {

        $this->db->select('idlom, id_estudiante');
        $this->db->where('idlom', $datos[1]);
        $this->db->where('id_estudiante', $datos[2]);
        $query = $this->db->get('usr_calificacion_oa');

        if ($query->num_rows() == 0) {
            $today = date("Y-m-d");
            $this->db->set('idrepository', $datos[0]);
            $this->db->set('idlom', $datos[1]);
            $this->db->set('calificacion', $datos[3]);
            $this->db->set('fecha', $today);
            $this->db->set('id_estudiante', $datos[2]);
            $this->db->insert('usr_calificacion_oa');
        } else {
            $today = date("Y-m-d");
            $this->db->set('idrepository', $datos[0]);
            $this->db->set('idlom', $datos[1]);
            $this->db->set('calificacion', $datos[3]);
            $this->db->set('fecha', $today);
            $this->db->set('id_estudiante', $datos[2]);
            $this->db->where('idlom', $datos[1]);
            $this->db->where('id_estudiante', $datos[2]);
            $this->db->update('usr_calificacion_oa');
        }
    }

    public function get_cal($id) {
        $this->db->select('idlom,calificacion');
        $this->db->where('id_estudiante', $id);
        $query = $this->db->get('usr_calificacion_oa');

        return $query->result();
    }

    public function get_mis_objetos($id) {
        $this->db->select('idlom');
        $this->db->select('idrepository');
        $this->db->where('id_estudiante', $id);
        $query = $this->db->get('usr_calificacion_oa');

        return $query->result();
    }
    public function get_roas(){
        $this->db->select('idrepository, name, affiliation, typerepository, url, registrationdate, lastupdate, countoas');
        $query = $this->db->get('repository');
        return $query->result_array();
        
    }

    public function get_usernames() {
        $this->db->select('id_estudiante');
        $query = $this->db->get('usr_estudiante');
        foreach ($query->result() as $key) {
            $data[] = $key->id_estudiante;
        }
        return $data;
    }

    public function update_test($estilo, $id) {

        $data = array(
            'id_estilo_aprendizaje' => $estilo
        );

        $this->db->where('id_estudiante', $id);
        $this->db->update('usr_estudiante', $data);
    }

    public function update_usr($id) {


        $data1 = array(
            'fecha_nacimiento' => $this->input->post('fecha_nac'),
            'sexo' => $this->input->post('sexo')
        );
        $var = $this->input->post('passwd');
        if (!empty($var)) {
            $data2 = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'username' => $this->input->post('username'),
                'clave' => md5($this->input->post('passwd')),
                'email' => $this->input->post('email'),
            );
        } else {
            $data2 = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'email' => $this->input->post('email'),
            );
        }


        $this->db->where('id_estudiante', $id);
        $this->db->update('usr_estudiante', $data1);


        $this->db->where('username', $id);
        $this->db->update('usuarios', $data2);
    }
    
    public function get_rol_user($username){
        $this->db->select('rol');
        $this->db->from("usuarios");
        $this->db->where("username",$username);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function insert_evaluation_expert($data){
        $this->db->insert('evaluation_expert',$data);        
        
    }
    
    public function insert_evaluation_user($data){
        $this->db->insert('evaluation_user',$data);
    }
    

}

?>
