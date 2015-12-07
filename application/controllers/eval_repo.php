<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Eval_repo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eval_model');
    }

    ///// MIRAR SI ESTO LO NECESITO
    public function index() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'username' => $session_data['username'],
                "title" => "Repositorios",
                "titulo" => "Administrador",
                "main" => "adm/lista_repo_view",
                "page" => "Inicio",
                "repos" => $this->repo_model->get_repo()
            );
            
            $this->load->view('include/adm_template1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function evaluar_oas() {
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
                $url = $res;
                //$url = "http://froac.manizales.unal.edu.co/harvester/FROAC-11.xml";

                //Se carga el contenido del archivo xml en $oas
                $doc = new DOMDocument();
                $doc->load($url);
                //Verifico el estándar de metadatos a analizar
                if ($metadata == "lom") {
                    //Se recorre el xml record por record
                    $oas = $doc->getElementsByTagName('record');
                    //Tenemos cada record
                    foreach ($oas as $oa) {

                        $header = $oa->getElementsByTagName('header');
                        global $idlom;
                        $idlom = $header->item(0)->getElementsByTagName('identifier')->item(0)->nodeValue;
                        $status = $header->item(0)->getAttribute('status');
                        $datestamp = $header->item(0)->getElementsByTagName('datestamp')->item(0)->nodeValue;

                        //Hago select para determinar la operación a realizar
                        $consult = $this->repo_model->get_lo($idrepository, $idlom);
                        $vlr = sizeof($consult);
                        $last = "";
                        if ($vlr == 0) {
                            //Quiere decir que no existe un registro de ese OA, entonces lo inserto
                            if ($status != 'deleted') {
                                //Hace falta implementar algo que permita obtener el xml correspondiente al OA que se está procesando
                                //$xmlo = $doc->saveXML();
                                $xmlo = "";
                                $data = array(
                                    'idrepository' => $idrepository,
                                    'idlom' => $idlom,
                                    'insertiondate' => date("Y-m-d"),
                                    'deleted' => 'false',
                                    'lastmodified' => $datestamp,
                                    'xmlo' => $xmlo
                                );
                                $this->repo_model->insert_table($data, 'lo');

                                $data2 = array(
                                    'idrepository' => $idrepository,
                                    'idlom' => $idlom
                                );
                                $this->repo_model->insert_table($data2, 'lom');
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
                                        'xmlo' => ''
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

                                    $this->repo_model->update_table($data, 'lo', $campos, $valores);

                                    $this->repo_model->delete_table('lom', $campos, $valores);

                                    $data2 = array(
                                        'idrepository' => $idrepository,
                                        'idlom' => $idlom
                                    );
                                    $this->repo_model->insert_table($data2, 'lom');
                                }
                            } else {
                                $data = array(
                                    'deleted' => 'true',
                                    'lastmodified' => $datestamp,
                                    'xmlo' => 'DELETEDqqq'
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

                                $this->repo_model->update_table($data, 'lo', $campos, $valores);

                                $this->repo_model->delete_table('lom', $campos, $valores);
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
        $cantOAs = $this->repo_model->get_cant_oas_repo($idrepository);
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
        $this->repo_model->update_table($data, 'repository', $campos, $valores);
        $this->lista_repo();
    }

//function
    ///////////////////// G E N E R A L /////////////
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
                $this->repo_model->insert_table($data, 'general_identifier');
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
                $this->repo_model->insert_table($data, 'general_language');
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
                $this->repo_model->insert_table($data, 'general_description');
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
                $this->repo_model->insert_table($data, 'general_keyword');
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
                $this->repo_model->insert_table($data, 'general_coverage');
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

            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
                $date = $contribute->getElementsByTagName('date')->item(0)->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idlifecyclecontribute' => $j,
                    'role' => $role,
                    'date' => $date
                );
                $this->repo_model->insert_table($data, 'lifecycle_contribute');
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
                    $this->repo_model->insert_table($data, 'lifecyclecontribute_entity');
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

            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
                $this->repo_model->insert_table($data, 'metametadata_identifier');
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
                $this->repo_model->insert_table($data, 'metametadata_contribute');
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
                    $this->repo_model->insert_table($data, 'metametadatacontribute_entity');
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
                $this->repo_model->insert_table($data, 'metametadata_metadataschema');
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

            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
                $this->repo_model->insert_table($data, 'technical_format');
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
                $this->repo_model->insert_table($data, 'technical_location');
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
                $this->repo_model->insert_table($data, 'technical_requirements');
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
                    $this->repo_model->insert_table($data, 'requirements_orcomposite');
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

            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
                $this->repo_model->insert_table($data, 'educational_learningresourcetype');
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
                $this->repo_model->insert_table($data, 'educational_intendedenduserrole');
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
                $this->repo_model->insert_table($data, 'educational_context');
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
                $this->repo_model->insert_table($data, 'educational_typicalagerange');
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
                $this->repo_model->insert_table($data, 'educational_description');
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
                $this->repo_model->insert_table($data, 'educational_language');
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

            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
                $this->repo_model->insert_table($data, 'relation_resource');
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
                    $this->repo_model->insert_table($data, 'resource_identifier');
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
                    $this->repo_model->insert_table($data, 'resource_description');
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
            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
            $this->repo_model->update_table($data, 'lom', $campos, $valores);
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
                $this->repo_model->insert_table($data, 'classification_taxonpath');
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
                    $this->repo_model->insert_table($data, 'taxonpath_taxon');
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
                $this->repo_model->insert_table($data, 'classification_keyword');
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
            $this->repo_model->update_table($data, 'lom', $campos, $valores);
        }
    }

    public function fuenterss() {
//        $frss = fopen("archivo.txt", 'w+');
//        //fwrite($frss, "header(Content-Type: text/xml)\n");
//        fwrite($frss, "<rss version=2.0>\n");
//        fwrite($frss, "<channel>\n");
//        fwrite($frss, "<title>Federacion de Repositorios de Objetos de Aprendizaje Colombia</title>\n");
//        fwrite($frss, "<link>http://froac.manizales.unal.edu.co/froac/</link>\n");
//        fwrite($frss, "<description>Repositorios de Objetos de Aprendizaje</description>");
//        flush();
//        $notices = $this->repo_model->get_rss_feeds();
//        foreach ($notices as $key) {
//            $search = $key["noticedate"];
//            $searchrepos = $this->repo_model->get_oas($search);
//            foreach ($searchrepos as $key2) {
//                fwrite($frss, "<item> \n" );
//                fwrite($frss, "<title>$key2[general_title]");
//                fwrite($frss, "</title> \n");
//                fwrite($frss, "<link>$key2[location]");
//                fwrite($frss, "</link> \n");
//                fwrite($frss, "<description>Una breve descripción sobre el artículo");
//                fwrite($frss, "</description> \n");
//                fwrite($frss, "</item> \n");
//                flush();
//                
//            }
//        }
////        echo "</channel> \n";
////        echo "</rss> \n";
//
//        fwrite($frss, "</channel> \n");
//        fwrite($frss, "</rss> \n");
//        fclose($frss);

        $css = base_url()."css/rss/rss.css";
        echo header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
        echo '<?xml-stylesheet type="text/css" href="'.$css.'" ?>';
        echo '<rss version="2.0">';
        echo "<channel>\n";
        echo "<title>Federacion de Repositorios de Objetos de Aprendizaje Colombia</title>\n";
        echo "<link>http://froac.manizales.unal.edu.co/froac/</link>\n";
//        echo "<description>Repositorios de Objetos de Aprendizaje</description>\n";
        $notices = $this->repo_model->get_rss_feeds();
//       echo $repositories;
        foreach ($notices as $key) {
            $search = $key["noticedate"];
            $searchrepos = $this->repo_model->get_oas($search);
            echo "<item> \n";
            echo "<title>$key[notice_title]";
            echo "</title> \n";
            echo "<link>http://froac.manizales.unal.edu.co/froac/";
            echo "</link> \n";
            echo "<description>";
            $i=0;
            foreach ($searchrepos as $key2) {
                $i+=1;
                echo "<p>";
                echo utf8_decode($key2['general_title']);
                echo "<a>";
                echo $key2['location'];
                echo "</a>";
                echo "</p>";
                if($i==10){
                    break;
                }
            }
            echo "</description> \n";
            echo "</item> \n";
        }
        echo "</channel> \n";
        echo "</rss> \n";
    }
}
?>