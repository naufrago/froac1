<?php

class Busqueda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }



    public function busqueda_simple($array) {
        $this->db->select('*');
        $this->db->from('lom');
        $this->db->join('general_description', 'lom.idlom = general_description.idlom and lom.idrepository = general_description.idrepository', 'left');
        $this->db->join('technical_format', 'lom.idlom = technical_format.idlom       and lom.idlom = technical_format.idlom and lom.idrepository = technical_format.idrepository', 'left');
        $this->db->join('technical_location', 'lom.idlom = technical_location.idlom   and lom.idlom = technical_location.idlom and lom.idrepository = technical_location.idrepository', 'left');
        $this->db->join('general_language', 'lom.idlom = general_language.idlom       and lom.idlom = general_language.idlom and lom.idrepository = general_language.idrepository', 'left');
        $this->db->join('general_keyword', 'lom.idlom = general_keyword.idlom and lom.idlom = general_keyword.idlom and lom.idrepository = general_keyword.idrepository');
        


        $query = $this->db->get();

        foreach ($query->result() as $row) {
           
               
             $data[$row->idlom ] = $row->description.' '.$row->keyword.' '.$row->general_title.' '.$row->format;
                
           
          
        }
        return $data;
        
     
    }
    
    
     public function consulta($id, $idrepo) {
        $this->db->select('*');
        $this->db->from('lom');
        $this->db->where('lom.idlom',$id); 
        $this->db->where('lom.idrepository',$idrepo);
        $this->db->join('general_description', 'lom.idlom = general_description.idlom and lom.idrepository = general_description.idrepository', 'left');
        $this->db->join('technical_format', 'lom.idlom = technical_format.idlom       and lom.idlom = technical_format.idlom and lom.idrepository = technical_format.idrepository', 'left');
        $this->db->join('technical_location', 'lom.idlom = technical_location.idlom   and lom.idlom = technical_location.idlom and lom.idrepository = technical_location.idrepository', 'left');
        $this->db->join('general_language', 'lom.idlom = general_language.idlom       and lom.idlom = general_language.idlom and lom.idrepository = general_language.idrepository', 'left');
        


        $query = $this->db->get();


        return $query->result();
        
     
    }
    
    public function get_id($consulta) {


        $query = $this->db->query($consulta);
        return $query->result_array();
     
    }
    
    public function identificaciones($id,$idrepo) {
        $this->db->select('lom.idrepository,lom.idlom');
        $this->db->from('lom');
        $this->db->where('lom.idlom',$id); 
        $this->db->where('lom.idrepository',$idrepo);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function titulos_recomendacion($idlom, $idrepository) {
       //recuperar los titulos y las localizaciones de los OAs resultado de la recomendación 
        $this->db->select('lom.general_title, technical_location.location');
        $this->db->from('lom');
        $this->db->where('lom.idrepository', $idrepository);
        $this->db->where('lom.idlom', $idlom);
        $this->db->join('technical_location', 'lom.idlom = technical_location.idlom   and lom.idlom = technical_location.idlom and lom.idrepository = technical_location.idrepository', 'left');
        $query = $this->db->get();
        
        return $query->result_array();
        
     }
    
}

?>
