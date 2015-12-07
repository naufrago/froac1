<?php

class Cosechado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cosechado_model');
    }
    
    public function index() {
        $query = $this->cosechado_model->get_roas_oai();
        $today = date("Y-m-d");
        echo $today;
        foreach ($query as $key) {
            $currendaterepo = $key['lastupdate'];
            $diferencia = $this->diferencia_fechas($currendaterepo, $today);
            if ($diferencia >= $key['frequency']) {
                $_POST['idrepository'] = $key['idrepository'];
                $_POST['lastupdate'] = $key['lastupdate'];
                $_POST['cadenaoai'] = $key['cadenaoai'];
                $_POST['metadata'] = $key['metadata'];
                $_POST['actualizar'] = $key['actualizar'];
                $_POST['fechainicio'] = $key[''];
                $_POST['fechafin'] = $key[''];
                echo 'Paso Por Aqui';
//                $_POST['idrepository'] = "654613212";
//                $_POST['lastupdate'] = "jhafjhgukehrn";
//                $_POST['cadenaoai'] = "AHKHCKHEIOHIONOIO";
//                $_POST['metadata'] = "kajdhjkga65531";
//                $_POST['actualizar'] = "kajkvnadfkvnuar";
//                $_POST['fechainicio'] = "JLJDRTVSV)()=(=(=)()=";
//                $_POST['fechafin'] = "&/(&#%&$&%$&%&";
                $this->actualizar_oas();
            }
        }
        $this->lista_repo();
    }

    public function actualizar_oas() {
        //  Prueba para El Cron                     
//        echo $idrepository;
//        echo $lastupdate;
//        echo $cadenaoai;
//        echo $metadata;
//        $nuevoarhivo = fopen("pruebacron.txt", 'w+');
//        fwrite($nuevoarhivo, "Esto deberia de estar funcionando");
//        fclose($nuevoarhivo);
        global $idrepository;
        $idrepository = $this->input->post("idrepository");
        $lastupdate = $this->input->post("lastupdate");
        $cadenaoai = $this->input->post("cadenaoai");
        $metadata = $this->input->post("metadata");
        $actualizar = $this->input->post("actualizar");
        $fechainicio = $this->input->post("fechainicio");
        $fechafin = $this->input->post("fechafin");


        $resp = $this->cosechado($actualizar, $idrepository, $lastupdate, $cadenaoai, $metadata, $fechainicio, $fechafin);
        if (count($resp) > 0) {
            //Este for se hace en caso de que se tengan varios xml asociados a la actualización
            //for ($v = 0; $v < count($resp); $v++) {
            foreach ($resp as $res) {
                //Ubicación de los archivos xml
                //$url= base_url()."harvester/".$idrepository."_".($i+1).".xml";
                //$url = base_url() . "harvester/FROAC3.xml";
                //$url = base_url() . $resp[$v];
                //$url = "http://froac.manizales.unal.edu.co/harvester/FROAC-11.xml";
                $url = $res;

                //Se carga el contenido del archivo xml en $oas
                $doc = new DOMDocument();
                $doc->load($url);
                //Verifico el estándar de metadatos a analizar
                if ($metadata == "lom") {
                    //Se recorre el xml record por record
                    $oas = $doc->getElementsByTagName('record');
                    //Tenemos cada record
                    $rssUpdate = 0;
                    $rssInsert = 0;
                    $rssLOUp = array();
                    $rssLOIn = array();
                    foreach ($oas as $oa) {

                        $header = $oa->getElementsByTagName('header');
                        global $idlom;
                        $idlom = $header->item(0)->getElementsByTagName('identifier')->item(0)->nodeValue;
                        $status = $header->item(0)->getAttribute('status');
                        $datestamp = $header->item(0)->getElementsByTagName('datestamp')->item(0)->nodeValue;
                        $xmlo = '';
                        if ($status != 'deleted') {
                            $xmlo0 = $oa->getElementsByTagName('lom');
                            $xmlo1 = $xmlo0->item(0);
                            $xml = $xmlo1->ownerDocument->saveXML($xmlo1);
                            $xmlo = $xml;
                        }
                        //Hago select para determinar la operación a realizar -- Miro si ya existía el OA
                        $consult = $this->cosechado_model->get_lo($idrepository, $idlom);
                        $vlr = sizeof($consult);
                        $last = "";
                        if ($vlr == 0) {
                            //Quiere decir que no existe un registro de ese OA, entonces lo inserto
                            if ($status != 'deleted') {
                                $data = array(
                                    'idrepository' => $idrepository,
                                    'idlom' => $idlom,
                                    'insertiondate' => date("Y-m-d"),
                                    'deleted' => 'false',
                                    'lastmodified' => $datestamp,
                                    'xmlo' => $xmlo
                                );
                                $this->cosechado_model->insert_table($data, 'lo');

                                $data2 = array(
                                    'idrepository' => $idrepository,
                                    'idlom' => $idlom
                                );
                                $this->cosechado_model->insert_table($data2, 'lom');

                                /* $data2 = array(
                                  'idrepository' => $idrepository,
                                  'idlom' => $idlom,
                                  'noticedate' => $datestamp,
                                  'notice_title' => "insert"
                                  );
                                  $this->cosechado_model->insert_table($data2, 'rss'); */
                                $rssLOIn[$rssInsert] = $idlom;
                                $rssInsert++;
                            }
                        } else {
                            foreach ($consult as $consu) {
                                $last = $consu['lastmodified'];
                            }
                            //Quiere decir que ya existe un registro de ese OA, entonces debo actualizarlo
                            if ($status != 'deleted') {
                                if ($last != $datestamp) {
                                    //Datos que se van a modificar
                                    $data = array(
                                        'lastmodified' => $datestamp,
                                        'xmlo' => $xmlo
                                    );

                                    //Capos para poner en el where
                                    $campos = array(
                                        '0' => 'idrepository',
                                        '1' => 'idlom'
                                    );

                                    //Valores para poner en el where
                                    $valores = array(
                                        '0' => $idrepository,
                                        '1' => $idlom
                                    );

                                    $this->cosechado_model->update_table($data, 'lo', $campos, $valores);

                                    $this->cosechado_model->delete_table('lom', $campos, $valores);

                                    $data2 = array(
                                        'idrepository' => $idrepository,
                                        'idlom' => $idlom
                                    );
                                    $this->cosechado_model->insert_table($data2, 'lom');

                                    /* $data2 = array(
                                      'idrepository' => $idrepository,
                                      'idlom' => $idlom,
                                      'noticedate' => $datestamp,
                                      'notice_title' => "update"
                                      );
                                      $this->cosechado_model->insert_table($data2, 'rss'); */
                                    $rssLOUp[$rssUpdate] = $idlom;
                                    $rssUpdate++;
                                }
                            } else {
                                $data = array(
                                    'deleted' => 'true',
                                    'lastmodified' => $datestamp,
                                    'xmlo' => $xmlo
                                );
                                //Capos para poner en el where
                                $campos = array(
                                    '0' => 'idrepository',
                                    '1' => 'idlom'
                                );

                                //Capos para poner en el where
                                $valores = array(
                                    '0' => $idrepository,
                                    '1' => $idlom
                                );

                                $this->cosechado_model->update_table($data, 'lo', $campos, $valores);

                                $this->cosechado_model->delete_table('lom', $campos, $valores);
                            }
                        }
                        if ($status != 'deleted') {
                            if ($last != $datestamp) {
                                $meta = $oa->getElementsByTagName('metadata')->item(0);
                                $this->importGeneral($meta, $idrepository, $idlom);
                                $this->importLifeCycle($meta, $idrepository, $idlom);
                                $this->importMetaMetaData($meta, $idrepository, $idlom);
                                $this->importTechnical($meta, $idrepository, $idlom);
                                $this->importEducational($meta, $idrepository, $idlom);
                                $this->importRights($meta, $idrepository, $idlom);
                                $this->importRelation($meta, $idrepository, $idlom);
                                $this->importAnnotation($meta, $idrepository, $idlom);
                                $this->importClassification($meta, $idrepository, $idlom);
                            }
                        }
                    }//foreach     
                }//if    
            }//for
        }//if
        //Hago select para determinar la operación a realizar
        $cantOAs = $this->cosechado_model->get_cant_oas_repo($idrepository);
        $data = array(
            'lastupdate' => date("Y-m-d"),
            'countoas' => $cantOAs
        );
        //Capos para poner en el where
        $campos = array(
            '0' => 'idrepository'
        );

        //Capos para poner en el where
        $valores = array(
            '0' => $idrepository
        );
        $this->cosechado_model->update_table($data, 'repository', $campos, $valores);

        $fecha = date("Y-m-d");

        //PROBLEMAS CON RSS
//        if ($rssInsert != 0) {
//            //Noticia de Insertar
//            $data2 = array(
//                'idrepository' => $idrepository,
//                'noticedate' => $fecha,
//                'notice_title' => "Se insertaron " . ($rssInsert - 1) . " objetos en ",
//                'noticetype' => "insert"
//            );
//            $this->cosechado_model->insert_table($data2, 'rss');
//            $idnotices = $this->cosechado_model->get_rss_idnotice($idrepository, $fecha, "insert");
//
//            foreach ($rssLOIn as $key => $lo) {
//                //Noticia de Insertar
//                $data3 = array(
//                    'idnotice' => $idnotices,
//                    'idlom' => $lo
//                );
//                $this->cosechado_model->insert_table($data3, 'rss_lom');
//            }
//        }
//
//        if ($rssUpdate != 0) {
//            //Noticia de Actualizar
//            $data4 = array(
//                'idrepository' => $idrepository,
//                'noticedate' => date("Y-m-d"),
//                'notice_title' => "Se actualizaron " . ($rssUpdate - 1) . " objetos en ",
//                'noticetype' => "update"
//            );
//            $this->cosechado_model->insert_table($data4, 'rss');
//
//            $idnotice = $this->cosechado_model->get_rss_idnotice($idrepository, $fecha, "update");
//            foreach ($rssLOUp as $key => $lo) {
//                //Noticia de Insertar
//                $data5 = array(
//                    'idnotice' => $idnotice,
//                    'idlom' => $lo
//                );
//                $this->cosechado_model->insert_table($data5, 'rss_lom');
//            }
//        }
        
    }

    public function lista_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'username' => $session_data['username'],
                "title" => "Lista Repositorios",
                "titulo" => "Administrador",
                "user" => $session_data['username'],
                "main" => "adm/lista_repo_view",
                "page" => "Registro",
                "repos" => $this->repo_model->get_repo(),
            );
            $this->load->view('include/adm_template1', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function cosechado($actualizar, $idrepository, $lastupdate, $cadenaoai, $metadata, $fechainicio, $fechafin) {
        //echo "Sale por este lado"+$actualizar;

        if ($actualizar == "1") //Todo
            $url = "http://localhost:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=&fechafin=";
        if ($actualizar == "2") //Ultima Actualización
            $url = "http://localhost:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $lastupdate . "&fechafin=";
        if ($actualizar == "3") //Rango de Fechas
            $url = "http://localhost:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $fechainicio . "&fechafin=" . $fechafin . "";
        /* if ($actualizar == "1") //Todo
          $url = "http://froac.manizales.unal.edu.co:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=&fechafin=";
          if ($actualizar == "2") //Ultima Actualización
          $url = "http://froac.manizales.unal.edu.co:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $lastupdate . "&fechafin=";
          if ($actualizar == "3") //Rango de Fechas
          $url = "http://froac.manizales.unal.edu.co:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $fechainicio . "&fechafin=" . $fechafin . "";
         */
        $tags = get_meta_tags($url);
        return $tags;
    }

    function importGeneral($meta, $idrepository, $idlom) {
        $tagGeneral = $meta->getElementsByTagName('general');
        foreach ($tagGeneral as $general) {
            /*             * *************************Identifier************************** */
            $tagIdentifier = $general->getElementsByTagName('identifier');
            $j = 1;
            foreach ($tagIdentifier as $identif) {
                $catalog = $identif->getElementsByTagName('catalog')->item(0)->nodeValue;
                $entry = $identif->getElementsByTagName('entry')->item(0)->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgeneralidentifier' => $j,
                    'catalog' => $catalog,
                    'entry' => $entry
                );
                $this->cosechado_model->insert_table($data, 'general_identifier');
                $j++;
            }
            /*             * *************************Title************************** */
            $title = $general->getElementsByTagName('title')->item(0)->nodeValue;
            /*             * *************************Language************************** */
            $tagLanguaje = $general->getElementsByTagName('language');
            $j = 1;
            foreach ($tagLanguaje as $language) {
                $lang = $language->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgenerallanguage' => $j,
                    'language' => $lang
                );
                $this->cosechado_model->insert_table($data, 'general_language');
                $j++;
            }
            /*             * *************************Description************************** */
            $tagDescription = $general->getElementsByTagName('description');
            $j = 1;
            foreach ($tagDescription as $description) {
                $descri = $description->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgeneraldescription' => $j,
                    'description' => $descri
                );
                $this->cosechado_model->insert_table($data, 'general_description');
                $j++;
            }
            /*             * *************************Keyword************************** */
            $tagKeyword = $general->getElementsByTagName('keyword');
            $j = 1;
            foreach ($tagKeyword as $keyword) {
                $key = $keyword->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgeneralkeyword' => $j,
                    'keyword' => $key
                );
                $this->cosechado_model->insert_table($data, 'general_keyword');
                $j++;
            }
            /*             * *************************Coverage************************** */
            $tagCoverage = $general->getElementsByTagName('coverage');
            $j = 1;
            foreach ($tagCoverage as $coverage) {
                $cove = $coverage->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgeneralcoverage' => $j,
                    'coverage' => $cove
                );
                $this->cosechado_model->insert_table($data, 'general_coverage');
                $j++;
            }
            /*             * *************************Structure************************** */
            $structure = $general->getElementsByTagName('structure')->item(0)->nodeValue;
            /*             * *************************Aggregationlevel************************** */
            $aggregationlevel = $general->getElementsByTagName('aggregationlevel')->item(0)->nodeValue;

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'general_title' => $title,
                'general_structure' => $structure,
                'general_aggregationlevel' => $aggregationlevel
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );

            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// L I F E   C Y C L E/////////////
    function importLifeCycle($meta, $idrepository, $idlom) {
        $tagLifecycle = $meta->getElementsByTagName('lifecycle');
        foreach ($tagLifecycle as $lifecycle) {
            /*             * *************************Version************************** */
            $version = $lifecycle->getElementsByTagName('version')->item(0)->nodeValue;
            /*             * *************************Status************************** */
            $status = $lifecycle->getElementsByTagName('status')->item(0)->nodeValue;
            /*             * *************************Contribute************************** */
            $tagContribute = $lifecycle->getElementsByTagName('contribute');
            $j = 1;
            foreach ($tagContribute as $contribute) {
                $role = $contribute->getElementsByTagName('role')->item(0)->nodeValue;
                
//Hacer condicional para verificar si el role es un author
                $date = $contribute->getElementsByTagName('date')->item(0)->nodeValue;
                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idlifecyclecontribute' => $j,
                    'role' => $role,
                    'date' => $date
                );
                $this->cosechado_model->insert_table($data, 'lifecycle_contribute');
                $x = 1;
                $tagEntity = $contribute->getElementsByTagName('entity');
                foreach ($tagEntity as $entity) {
                    $enti = $entity->nodeValue;
                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idlifecyclecontribute' => $j,
                        'idlifecyclecontributeentity' => $x,
                        'entity' => $enti
                    );
                    $this->cosechado_model->insert_table($data, 'lifecyclecontribute_entity');
                    $x++;
                }
                $j++;
            }

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'lifecycle_version' => $version,
                'lifecycle_status' => $status
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );

            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// M E T A - M E T A D A T A /////////////
    function importMetaMetaData($meta, $idrepository, $idlom) {
        $tagMetametadata = $meta->getElementsByTagName('metametadata');
        foreach ($tagMetametadata as $metametadata) {
            /*             * *************************Identifier************************** */
            $tagIdentifier = $metametadata->getElementsByTagName('identifier');
            $j = 1;
            foreach ($tagIdentifier as $identif) {
                $catalog = $identif->getElementsByTagName('catalog')->item(0)->nodeValue;
                $entry = $identif->getElementsByTagName('entry')->item(0)->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idmetametadataidentifier' => $j,
                    'catalog' => $catalog,
                    'entry' => $entry
                );
                $this->cosechado_model->insert_table($data, 'metametadata_identifier');
                $j++;
            }
            /*             * *************************Contribute************************** */
            $tagContribute = $metametadata->getElementsByTagName('contribute');
            $j = 1;
            foreach ($tagContribute as $contribute) {
                $role = $contribute->getElementsByTagName('role')->item(0)->nodeValue;
                $date = $contribute->getElementsByTagName('date')->item(0)->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idmetametadatacontribute' => $j,
                    'role' => $role,
                    'date' => $date
                );
                $this->cosechado_model->insert_table($data, 'metametadata_contribute');
                $x = 1;
                $tagEntity = $contribute->getElementsByTagName('entity');
                foreach ($tagEntity as $entity) {
                    $enti = $entity->nodeValue;
                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idmetametadatacontribute' => $j,
                        'idmetametadatacontributeentity' => $x,
                        'entity' => $enti
                    );
                    $this->cosechado_model->insert_table($data, 'metametadatacontribute_entity');
                    $x++;
                }
                $j++;
            }
            /*             * *************************Metadataschema************************** */
            $tagMetadataschema = $metametadata->getElementsByTagName('metadataschema');
            $j = 1;
            foreach ($tagMetadataschema as $metadataschema) {
                $metasche = $metadataschema->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idmetametadatametadataschema' => $j,
                    'metadataschema' => $metasche
                );
                $this->cosechado_model->insert_table($data, 'metametadata_metadataschema');
                $j++;
            }
            /*             * *************************Language************************** */
            $language = $metametadata->getElementsByTagName('language')->item(0)->nodeValue;

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'metametadata_language' => $language
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );

            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// T E C H N I C A L /////////////
    function importTechnical($meta, $idrepository, $idlom) {
        $tagTechnical = $meta->getElementsByTagName('technical');
        foreach ($tagTechnical as $technical) {
            /*             * *************************Format************************** */
            $tagFormat = $technical->getElementsByTagName('format');
            $j = 1;
            foreach ($tagFormat as $format) {
                $form = $format->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idtechnicalformat' => $j,
                    'format' => $form
                );
                $this->cosechado_model->insert_table($data, 'technical_format');
                $j++;
            }
            /*             * *************************Size************************** */
            $size = $technical->getElementsByTagName('size')->item(0)->nodeValue;
            /*             * *************************Location************************** */
            $tagLocation = $technical->getElementsByTagName('location');
            $j = 1;
            foreach ($tagLocation as $location) {
                $locat = $location->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idtechnicallocation' => $j,
                    'location' => $locat
                );
                $this->cosechado_model->insert_table($data, 'technical_location');
                $j++;
            }
            /*             * *************************Requirements************************** */
            $tagRequirements = $technical->getElementsByTagName('requirements');
            $j = 1;
            foreach ($tagRequirements as $requirements) {

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idtechnicalrequirements' => $j
                );
                $this->cosechado_model->insert_table($data, 'technical_requirements');
                $x = 1;
                $tagOromposite = $requirements->getElementsByTagName('oromposite');
                foreach ($tagOromposite as $oromposite) {
                    $type = $oromposite->getElementsByTagName('type')->item(0)->nodeValue;
                    $name = $oromposite->getElementsByTagName('name')->item(0)->nodeValue;
                    $minimumversion = $oromposite->getElementsByTagName('minimumversion')->item(0)->nodeValue;
                    $maximumversion = $oromposite->getElementsByTagName('maximumversion')->item(0)->nodeValue;

                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idtechnicalrequirements' => $j,
                        'idrequirementsorcomposite' => $x,
                        'type' => $type,
                        'name' => $name,
                        'minimumversion' => $minimumversion,
                        'maximumversion' => $maximumversion
                    );
                    $this->cosechado_model->insert_table($data, 'requirements_orcomposite');
                    $x++;
                }
                $j++;
            }
            /*             * *************************Installationremarks************************** */
            $Installationremarks = $technical->getElementsByTagName('installationremarks')->item(0)->nodeValue;
            /*             * *************************Otherplatformrequirements************************** */
            $Otherplatform = $technical->getElementsByTagName('otherplatformrequirements')->item(0)->nodeValue;
            /*             * *************************Duration************************** */
            $duration = $technical->getElementsByTagName('duration')->item(0)->nodeValue;

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'technical_size' => $size,
                'technical_installationremarks' => $Installationremarks,
                'technical_otherplatformrequirements' => $Otherplatform,
                'technical_duration' => $duration
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );

            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// E D U C A T I O N A L /////////////
    function importEducational($meta, $idrepository, $idlom) {
        $tagEducational = $meta->getElementsByTagName('educational');
        foreach ($tagEducational as $educational) {
            /*             * *************************Interactivitytype************************** */
            $interactivitytype = $educational->getElementsByTagName('interactivitytype')->item(0)->nodeValue;
            /*             * *************************Learningresourcetype************************** */
            $tagLearningresourcetype = $educational->getElementsByTagName('learningresourcetype');
            $j = 1;
            foreach ($tagLearningresourcetype as $learningresourcetype) {
                $resourcetype = $learningresourcetype->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationallearningresourcetype' => $j,
                    'learningresourcetype' => $resourcetype
                );
                $this->cosechado_model->insert_table($data, 'educational_learningresourcetype');
                $j++;
            }
            /*             * *************************Interactivitylevel************************** */
            $interactivitylevel = $educational->getElementsByTagName('interactivitylevel')->item(0)->nodeValue;
            /*             * *************************Semanticdensity************************** */
            $semanticdensity = $educational->getElementsByTagName('semanticdensity')->item(0)->nodeValue;
            /*             * *************************Intendedenduserrole************************** */
            $tagIntendedenduserrole = $educational->getElementsByTagName('intendedenduserrole');
            $j = 1;
            foreach ($tagIntendedenduserrole as $intendedenduserrole) {
                $intended = $intendedenduserrole->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationalintendedenduserrole' => $j,
                    'intendedenduserrole' => $intended
                );
                $this->cosechado_model->insert_table($data, 'educational_intendedenduserrole');
                $j++;
            }
            /*             * *************************Context************************** */
            $tagContext = $educational->getElementsByTagName('context');
            $j = 1;
            foreach ($tagContext as $context) {
                $conte = $context->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationalcontext' => $j,
                    'context' => $conte
                );
                $this->cosechado_model->insert_table($data, 'educational_context');
                $j++;
            }
            /*             * *************************Typical Age Range************************** */
            $tagTypicalagerange = $educational->getElementsByTagName('typicalagerange');
            $j = 1;
            foreach ($tagTypicalagerange as $typicalagerange) {
                $typical = $typicalagerange->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationaltypicalagerange' => $j,
                    'typicalagerange' => $typical
                );
                $this->cosechado_model->insert_table($data, 'educational_typicalagerange');
                $j++;
            }
            /*             * *************************Difficulty************************** */
            $difficulty = $educational->getElementsByTagName('difficulty')->item(0)->nodeValue;
            /*             * *************************Typical Learning Time************************** */
            $typicallearningtime = $educational->getElementsByTagName('typicallearningtime')->item(0)->nodeValue;
            /*             * *************************Description************************** */
            $tagDescription = $educational->getElementsByTagName('description');
            $j = 1;
            foreach ($tagDescription as $description) {
                $descri = $description->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationaldescription' => $j,
                    'description' => $descri
                );
                $this->cosechado_model->insert_table($data, 'educational_description');
                $j++;
            }
            /*             * *************************Language************************** */
            $tagLanguage = $educational->getElementsByTagName('language');
            $j = 1;
            foreach ($tagLanguage as $language) {
                $lang = $language->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationallanguage' => $j,
                    'language' => $lang
                );
                $this->cosechado_model->insert_table($data, 'educational_language');
                $j++;
            }

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'educational_interactivitytype' => $interactivitytype,
                'educational_interactivitylevel' => $interactivitylevel,
                'educational_semanticdensity' => $semanticdensity,
                'educational_difficulty' => $difficulty,
                'educational_typicallearningtime' => $typicallearningtime
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );

            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// R I G H T S /////////////
    function importRights($meta, $idrepository, $idlom) {
        $tagRights = $meta->getElementsByTagName('rights');
        foreach ($tagRights as $rights) {
            /*             * *************************Cost************************** */
            $cost = $rights->getElementsByTagName('cost')->item(0)->nodeValue;
            /*             * *************************Copyright And Other Restrictions************************** */
            $otherrestrictions = $rights->getElementsByTagName('copyrightandotherrestrictions')->item(0)->nodeValue;
            /*             * *************************Size************************** */
            $description = $rights->getElementsByTagName('description')->item(0)->nodeValue;


            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'rights_cost' => $cost,
                'rights_copyrightandotherrestrictions' => $otherrestrictions,
                'rights_description' => $description
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );
            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// R E L A T I O N /////////////
    function importRelation($meta, $idrepository, $idlom) {
        $tagRelation = $meta->getElementsByTagName('relation');
        foreach ($tagRelation as $relation) {
            /*             * *************************Kind************************** */
            $kind = $relation->getElementsByTagName('kind')->item(0)->nodeValue;
            /*             * *************************Resource************************** */
            $tagResource = $relation->getElementsByTagName('resource');
            $j = 1;
            foreach ($tagResource as $resource) {

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idrelationresource' => $j
                );
                $this->cosechado_model->insert_table($data, 'relation_resource');
                //Identifier
                $x = 1;
                $tagIdentifier = $resource->getElementsByTagName('identifier');
                foreach ($tagIdentifier as $identif) {
                    $catalog = $identif->getElementsByTagName('catalog')->item(0)->nodeValue;
                    $entry = $identif->getElementsByTagName('entry')->item(0)->nodeValue;

                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idrelationresource' => $j,
                        'idresourceidentifier' => $x,
                        'catalog' => $catalog,
                        'entry' => $entry
                    );
                    $this->cosechado_model->insert_table($data, 'resource_identifier');
                    $x++;
                }
                //Description
                $tagDescription = $resource->getElementsByTagName('description');
                $y = 1;
                foreach ($tagDescription as $description) {
                    $descri = $description->nodeValue;

                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idrelationresource' => $j,
                        'idresourcedescription' => $y,
                        'description' => $descri
                    );
                    $this->cosechado_model->insert_table($data, 'resource_description');
                    $y++;
                }
                $j++;
            }

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'relation_kind' => $kind
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );
            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// A N N O T A T I O N /////////////
    function importAnnotation($meta, $idrepository, $idlom) {
        $tagAnnotation = $meta->getElementsByTagName('annotation');
        foreach ($tagAnnotation as $annotation) {
            /*             * *************************Cost************************** */
            $entity = $annotation->getElementsByTagName('entity')->item(0)->nodeValue;
            /*             * *************************Copyright And Other Restrictions************************** */
            $date = $annotation->getElementsByTagName('date')->item(0)->nodeValue;
            /*             * *************************Size************************** */
            $description = $annotation->getElementsByTagName('description')->item(0)->nodeValue;


            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'annotation_entity' => $entity,
                'annotation_date' => $date,
                'annotation_description' => $description
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );
            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    ///////////////////// C L A S S I F I C A T I O N /////////////
    function importClassification($meta, $idrepository, $idlom) {
        $tagClassification = $meta->getElementsByTagName('classification');
        foreach ($tagClassification as $classification) {
            /*             * *************************Purpose************************** */
            $purpose = $classification->getElementsByTagName('purpose')->item(0)->nodeValue;
            /*             * *************************Taxon Path************************** */
            $tagTaxonpath = $classification->getElementsByTagName('taxonpath');
            $j = 1;
            foreach ($tagTaxonpath as $taxonpath) {
                $source = $taxonpath->getElementsByTagName('source')->item(0)->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idclassificationtaxonpath' => $j,
                    'source' => $source
                );
                $this->cosechado_model->insert_table($data, 'classification_taxonpath');
                //Taxon
                $x = 1;
                $tagTaxon = $taxonpath->getElementsByTagName('taxon');
                foreach ($tagTaxon as $taxon) {
                    $id = $taxon->getElementsByTagName('id')->item(0)->nodeValue;
                    $entry = $taxon->getElementsByTagName('entry')->item(0)->nodeValue;

                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idclassificationtaxonpath' => $j,
                        'idtaxonpathtaxon' => $id,
                        'entry' => $entry
                    );
                    $this->cosechado_model->insert_table($data, 'taxonpath_taxon');
                    $x++;
                }
                $j++;
            }
            /*             * *************************Description************************** */
            $description = $classification->getElementsByTagName('description')->item(0)->nodeValue;
            /*             * *************************Keyword************************** */
            $tagKeyword = $classification->getElementsByTagName('keyword');
            $j = 1;
            foreach ($tagKeyword as $keyword) {
                $key = $keyword->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idclassificationkeyword' => $j,
                    'keyword' => $key
                );
                $this->cosechado_model->insert_table($data, 'classification_keyword');
                $j++;
            }

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'classification_purpose' => $purpose,
                'classification_description' => $description
            );
            //Capos para poner en el where
            $campos = array(
                '0' => 'idrepository',
                '1' => 'idlom'
            );

            //Capos para poner en el where
            $valores = array(
                '0' => $idrepository,
                '1' => $idlom
            );
            $this->cosechado_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    

    function diferencia_fechas($inicio, $fin) {
        $start_ts = strtotime($inicio);

        $end_ts = strtotime($fin);

        $diff = $end_ts - $start_ts;

        return round($diff / 86400);
    }

}

?>
