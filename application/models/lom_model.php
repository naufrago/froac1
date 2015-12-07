<?php

class Lom_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_list_lom($limit1, $limit2) {
        $this->db->select('*');
        $this->db->from('lom');
        $this->db->join('general_description', 'lom.idlom = general_description.idlom and lom.idrepository = general_description.idrepository', 'left');
        $this->db->join('technical_format', 'lom.idlom = technical_format.idlom       and lom.idlom = technical_format.idlom and lom.idrepository = technical_format.idrepository', 'left');
        $this->db->join('technical_location', 'lom.idlom = technical_location.idlom   and lom.idlom = technical_location.idlom and lom.idrepository = technical_location.idrepository', 'left');
        $this->db->join('general_language', 'lom.idlom = general_language.idlom       and lom.idlom = general_language.idlom and lom.idrepository = general_language.idrepository', 'left');
        $this->db->limit($limit1, $limit2);
        $this->db->order_by('lom.idlom', 'asc');




        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
        public function get_list_lom_r($id_rep, $limit1, $limit2) {
        $this->db->select('*');
        $this->db->from('lom');
        $this->db->where('lom.idrepository', $id_rep);
        $this->db->join('general_description', 'lom.idlom = general_description.idlom and lom.idrepository = general_description.idrepository', 'left');
        $this->db->join('technical_format', 'lom.idlom = technical_format.idlom       and lom.idlom = technical_format.idlom and lom.idrepository = technical_format.idrepository', 'left');
        $this->db->join('technical_location', 'lom.idlom = technical_location.idlom   and lom.idlom = technical_location.idlom and lom.idrepository = technical_location.idrepository', 'left');
        $this->db->join('general_language', 'lom.idlom = general_language.idlom       and lom.idlom = general_language.idlom and lom.idrepository = general_language.idrepository', 'left');
        $this->db->limit($limit1, $limit2);
        $this->db->order_by('lom.idlom', 'asc');




        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_keyword($id, $idrep) {

        $query = $this->db->get_where('general_keyword', array('idlom' => $id, 'idrepository' => $idrep));


        return $query->result_array();
    }

    public function get_a_keyword() {
        $query = $this->db->get('general_keyword');
        return $query->result_array();
    }

    public function insert_lo($repository, $idlo, $type) {
        try {
            $query = "INSERT INTO loadlo VALUES($repository,$idlo,$type,now())";
            $this->db->query($query);
            return "OK";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function total($limit1, $limit2) {
        $query = $this->db->get('lom', $limit1, $limit2);
        return $query->num_rows();
    }
    

    public function cantidad() {
        $query = $this->db->count_all('lom');
        return $query;
    }

    public function oas_repositorio($id_repositorio) {


        $this->db->select('*');
        $this->db->from('lom');
        $this->db->where('lom.idrepository', $id_repositorio);
        $this->db->join('general_description', 'lom.idlom = general_description.idlom and lom.idrepository = general_description.idrepository', 'left');
        $this->db->join('technical_format', 'lom.idlom = technical_format.idlom       and lom.idlom = technical_format.idlom and lom.idrepository = technical_format.idrepository', 'left');
        $this->db->join('technical_location', 'lom.idlom = technical_location.idlom   and lom.idlom = technical_location.idlom and lom.idrepository = technical_location.idrepository', 'left');
        $this->db->join('general_language', 'lom.idlom = general_language.idlom       and lom.idlom = general_language.idlom and lom.idrepository = general_language.idrepository', 'left');

        $query = $this->db->get();

        return $query->result();
    }

}

?>
