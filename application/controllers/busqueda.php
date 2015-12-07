<?php

require_once 'lib/lib/nusoap.php';
require_once 'stemm_es.php';

class Busqueda extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('busqueda_model');
        $this->load->model('lom_model');
        $this->load->model('usuario_model');
    }

    public function query($cadena) {

       
        $cadena = trim(urldecode($cadena));
        $cadena2 = "";
        $tam = explode("|", $cadena);
        for ($i = 0; $i <= sizeof($tam) - 1; $i++) {

            if (!empty($tam[$i])) {
                $cadena2 = $cadena2 . '&' . stemm_es::stemm($tam[$i]);
            }
        }
        $cadena2 = substr($cadena2, 1);
        if (sizeof($tam) >= 2) {


            $query = "SELECT idlom, idrepository, ts_rank_cd(search_index_col, query) AS rank
         FROM general_description, to_tsquery('spanish','$cadena2') query
         WHERE query @@ search_index_col
         ORDER BY rank DESC;";

            $id_prin = $this->busqueda_model->get_id($query);

            foreach ($id_prin as $key) {
                $result[] = $this->busqueda_model->consulta(strval($key['idlom']), $key['idrepository']);
                $words[] = $this->lom_model->get_keyword(strval($key['idlom']), $key['idrepository']);
            }
        }else{
            $query2 = "SELECT idlom, idrepository, ts_rank_cd(search_index_col, query) AS rank
         FROM general_description, to_tsquery('spanish','$cadena2') query
         WHERE query @@ search_index_col
         ORDER BY rank DESC;";


        $id_dos = $this->busqueda_model->get_id($query2);



        foreach ($id_dos as $key) {
            $result[] = $this->busqueda_model->consulta(strval($key['idlom']), $key['idrepository']);
            $words[] = $this->lom_model->get_keyword(strval($key['idlom']), $key['idrepository']);
            $x[] = $this->busqueda_model->identificaciones(strval($key['idlom']), $key['idrepository']);
            //$evaluation[] = $this->busqueda_model->evaluation_oa(strval($key['idlom']), $key['idrepository']);
        }
        }


        


        // echo '------------------------------------------<br>';

        foreach ($result as $key) {
            $data[] = $key;
        }

        foreach ($words as $key) {
            $keyword[] = $key;
        }
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol_user($session_data['username']);
            if ((string) $rol[0]['rol'] == '7') {
                $content = array(
                    'username' => $session_data['username'],
                    'rol' => $rol[0]['rol'],
                    "title" => "OA'S",
                    "main" => "usr/oas_view",
                    "lom" => $data,
                    "keyword" => $keyword,
                    'cal' => $this->usuario_model->get_cal($session_data['username']),
                    "evaluation" => $evaluation
                );
            } else {
                $content = array(
                    'username' => $session_data['username'],
                    'rol' => $rol[0]['rol'],
                    "title" => "OA'S",
                    "main" => "usr/oas_view",
                    "lom" => $data,
                    "keyword" => $keyword,
                    'cal' => $this->usuario_model->get_cal($session_data['username']),
                    'p' => $this->hacer_recomendacion($x, $session_data['username']),
                    "evaluation" => $evaluation
                );
            }
        } else {
            $content = array(
                "title" => "OA'S",
                "main" => "usr/oas_view",
                'rol' => 0,
                "lom" => $data,
                "keyword" => $keyword,
                "evaluation" => $evaluation
            );
        }
        $this->load->view('usr/result_view', $content);
    }

    //////////////////RECOMENDACIÓN!!!!! 
    public function hacer_recomendacion($recom, $usuario) {
        for ($i = 0; $i < count($recom); $i++) {
            for ($r = 0; $r < count($recom[$i]); $r++) {
                $p[$i]['idOA'] = $recom[$i][$r]['idlom'];
                $p[$i]['idRepository'] = $recom[$i][$r]['idrepository'];
            }
        }


        $parametros = array(
            'idUsuarioActivo' => $usuario,
            'OAs' => $p
        );


        $wsdl_url = 'http://localhost:6020/ServicioWeb?wsdl';
        //  $wsdl_url = 'http://froac.manizales.unal.edu.co:6020/ServicioWeb';
        $client = new SOAPClient($wsdl_url);



        $result = $client->adaptarOAs($parametros);
        $cadena = "";
        $otro = "";

        foreach ($result as $paulis) {
            foreach ($paulis as $no) {
                $cadena = $cadena . $no->idOA . "-" . $no->idRepository . "$";
            }
        }
        //$this->llenar_recomendacion($p,$supone);
//        $this->llenar_recomendacion($result);
        return $cadena;
    }

    public function llenar_recomendacion($return1) {
//        $i=0;
//    foreach ($return1 as $paulis) {
//            foreach ($paulis as $no) {
//                    $rec[$i] = $this->busqueda_model->titulos_recomendacion($no->idOA, $no->idRepository);
//                    $i++;
//            }
//        }
//        
//          
//        $data = array(
//            "rec" => $rec
//        );
// 
//        
//        $this->load->view('usr/llenar_recomendacion_view', $data);

        $return = urldecode($return1);

        $ob = explode("$", $return);
        $ob1 = array_pop($ob);
        $todos = array();
        foreach ($ob as $key) {
            $temp = explode("-", $key);
            $comp = array(
                'idOA' => $temp[0],
                'idRepository' => $temp[1]
            );
            array_push($todos, $comp);
        }
        //print_r($todos);
        //Con los id de los OAs recomendados, busco el titulo y la localización 
        for ($i = 0; $i < count($todos); $i++) {
            $rec[$i] = $this->busqueda_model->titulos_recomendacion($todos[$i]['idOA'], $todos[$i]['idRepository']);
        }

        $data = array(
            "rec" => $rec
        );


        $this->load->view('usr/llenar_recomendacion_view', $data);
    }

    public function busqueda_avanzada_form() {
        $this->load->view('usr/avanzada_view');
    }

    public function query_pr($cadena) {
        $cadena = trim(urldecode($cadena));
        $cadena2 = "";
        echo $cadena;
        $tam = explode("|", $cadena);
        for ($i = 0; $i <= sizeof($tam) - 1; $i++) {

            if (!empty($tam[$i])) {
                $cadena2 = $cadena2 . '&' . stemm_es::stemm($tam[$i]);
            }
        }
        $cadena2 = substr($cadena2, 1);
        echo '<br>';
        echo $cadena2;

//        $query = "SELECT idlom, idrepository, ts_rank_cd(search_index_col, query) AS rank
//         FROM general_description, to_tsquery('spanish',lower(quitar_acento('$cadena2'))) query
//         WHERE query @@ search_index_col
//         ORDER BY rank DESC;";
//
//        $id_prin = $this->busqueda_model->get_id($query);
//
//        foreach ($id_prin as $key) {
//            $result[] = $this->busqueda_model->consulta(strval($key['idlom']), $key['idrepository']);
//            $words[] = $this->lom_model->get_keyword(strval($key['idlom']), $key['idrepository']);
//        }
//
//        print_r($result);
    }

}

?>