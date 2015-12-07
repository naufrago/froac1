<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Rss extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rss_model');
    }

    public function index() {
       $content = array(
            "title" => "¿Que es RSS?",
            'main' => 'usr/rss_view');
        $this->load->view('include/u_template1', $content);
    }
    
    public function noticias_rss(){
         $css = base_url() . "css/rss/rss.css";
        echo header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
        echo '<?xml-stylesheet type="text/css" href="' . $css . '" ?>';
        echo '<rss version="2.0">';
        echo "<channel>\n";
        echo "<title>Federacion de Repositorios de Objetos de Aprendizaje Colombia</title>\n";
        echo "<link>http://froac.manizales.unal.edu.co/froac/</link>\n";
//        echo "<description>Repositorios de Objetos de Aprendizaje</description>\n";
        $notices = $this->rss_model->get_rss_feeds();

//       echo $repositories;
        foreach ($notices as $key) {
            
            $search = $key['idnotice'];
            $searchrepos = $this->rss_model->get_oas($search);
            echo "<item> \n";
            $noticia = utf8_decode($key['notice_title']) . " del repositorio " . utf8_decode($key['name']);
            echo "<title> $noticia";
            echo "</title> \n";
            echo "<link>http://froac.manizales.unal.edu.co/froac/";
            echo "</link> \n";
            echo "<description>";

            foreach ($searchrepos as $key2) {
                echo "<p>";
                echo utf8_decode($key2['general_title']);
                echo "<a>";
                echo utf8_decode($key2['location']);
                echo "</a>";
                echo "</p>";
            }
            echo "</description> \n";
            echo "</item> \n";
        }
        echo "</channel> \n";
        echo "</rss> \n";
    }
}
?>