<?php
class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('busqueda_model');
        $this->load->model('lom_model');

        $this->load->library('form_validation');
    }

    public function index() {

        $content = array(
            "title" => "Registro usuario",
            "main" => "usr/formulario_registro_view",
            "preferencias" => $this->usuario_model->get_preferencias(),
            "usernames" => $this->usuario_model->get_usernames(),
        );
        $this->load->view('include/u_template1', $content);
    }

    public function test() {

        $this->load->view('usr/formulario_test_view');
    }
    
      public function checkusr($user){
          $usr = urldecode($user);
        $usernames = $this->usuario_model->get_usernames();
        if (in_array($usr, $usernames)){
            echo 1;
        }else
            echo 2;
    }
    
    public function test_result() {

        $this->clasificaresp();
    }

    public function guardar() {
        $this->usuario_model->guardar_estudiante();
        foreach ($_POST['pref'] as $key => $value) {
            $this->usuario_model->insert_pref($value, $this->input->post('username'));
        }
        $name = $this->input->post('nombre') . ' ' . $this->input->post('apellido');
        $this->exito($this->input->post('username'), $name);
    }

    public function exito($id, $name) {

        $content = array(
            "title" => "Registro éxitoso",
            "main" => "usr/exito_view",
            "username" => $id,
            "name" => $name
        );
        $this->load->view('include/u_templateEx', $content);
    }

    function check() {
        //This method will have the credentials validation


        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required|xss_clean|callback_check_database');
        $rol = $this->usuario_model->get_rol_usr($this->input->post('username'));
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            redirect('init', 'refresh');
        } else {
            //Go to private area
            $this->admin($rol);
        }
    }

    public function logout() {

        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
//        session_destroy();
        redirect(base_url(), 'refresh');
    }

    function admin($rol) {

        switch ($rol[0]['rol']) {
            case 1:
                redirect('adm_repo', 'refresh');
                break;
            case 2:
                redirect('adm_ent_repo', 'refresh');
                break;
            case 3:
                redirect('init_user', 'refresh');
                break;
            case 4:
                redirect('init_user', 'refresh');
                break;
            case 6:
                redirect('adm_ent_repo', 'refresh');
                break;
            case 7:
                redirect('init_user','refresh');
                break;
        }
    }

    function check_database($password) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');

        //query the database
        $result = $this->usuario_model->login($username, $password);

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    
                    'username' => $row->username
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Usuario o password inválido, por favor intente de nuevo');
            return false;
        }
    }

    public function clasificaresp() {


        $cant_V = 0;
        $cant_A = 0;
        $cant_R = 0;
        $cant_K = 0;

        $cant_G = 0;
        $cant_S = 0;

        for ($i = 1; $i <= 48; $i++) {
            if ($this->input->post($i) == 'V')
                $cant_V++;

            if ($this->input->post($i) == 'A')
                $cant_A++;

            if ($this->input->post($i) == 'R')
                $cant_R++;

            if ($this->input->post($i) == 'K')
                $cant_K++;
        }
        /*
          echo '   Cantidad de V    ';
          echo $cant_V;

          echo '   Cantidad de A    ';
          echo $cant_A;

          echo '   Cantidad de R    ';
          echo $cant_R;

          echo '   Cantidad de K    ';
          echo $cant_K; */

        //GLOBAL _ SECUENCIAL 

        for ($j = 49; $j <= 70; $j++) {
            if ($this->input->post($j) == 'G')
                $cant_G++;
            if ($this->input->post($j) == 'S')
                $cant_S++;
        }

        /* echo "   cantidad G  ";
          echo $cant_G;
          echo "   cantidad S  ";
          echo $cant_S; */



        // $mayor = "";

        $puntaje = 0;
        if ($cant_V >= $cant_A && $cant_V >= $cant_R && $cant_V >= $cant_K) {
            $mayor = 7; //Visual
            $puntaje = $cant_V;
        } else
        if ($cant_A >= $cant_V && $cant_A >= $cant_R && $cant_A >= $cant_K) {
            $mayor = 1; //Auditivo
            $puntaje = $cant_A;
        } else
        if ($cant_R >= $cant_V && $cant_R >= $cant_A && $cant_R >= $cant_K) {
            $mayor = 5; //Lector
            $puntaje = $cant_R;
        } else
        if ($cant_K >= $cant_R && $cant_K >= $cant_V && $cant_K >= $cant_A) {
            $mayor = 3; //kinestesico
            $puntaje = $cant_K;
        }

        if ($cant_G >= $cant_S) {
            $mayor = $mayor + 0; //Global
            $puntaje = $puntaje . '-' . $cant_G;
        } else {
            $mayor = $mayor + 1; //Secuencial
            $puntaje = $puntaje . ' - ' . $cant_S;
        }


        //echo 'Su estilo de aprendizaje es: ' . $mayor . ' con un resultado de ' . $puntaje;

        echo $mayor;

        //$this->usuario_model->guardar_test();
    }
    
    public function mi_cuenta() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $obj = $this->usuario_model->get_mis_objetos($session_data['username']);
            // print_r($obj);
            foreach ($obj as $key) {
                //echo  $key->idlom;
                $result[] = $this->busqueda_model->consulta($key->idlom, $key->idrepository);
                $words[] = $this->lom_model->get_keyword($key->idlom, $key->idrepository);
            }

            foreach ($result as $key) {
                $data[] = $key;
            }

            foreach ($words as $key) {
                $keyword[] = $key;
            }

            $data = array(
                'username' => $session_data['username'],
                'main' => 'usr/mi_cuenta_view',
                'title' => 'Mi Cuenta',
                'info' => $this->usuario_model->get_usuario_est($session_data['username']),
                'preferencia' => $this->usuario_model->get_preferencia_est($session_data['username']),
                "preferencias" => $this->usuario_model->get_preferencias(),
                'lom' => $data,
                'keyword' => $keyword,
                'cal' => $this->usuario_model->get_cal($session_data['username'])
                
            );
            $this->load->view('include/u_template1_1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function calificar() {
        $new = explode('+', $this->input->post('datos'));
        $this->usuario_model->guardar_calificacion($new);
    }
    
    public function up_preferencia(){
        $this->usuario_model->update_preferencia();
        $this->mi_cuenta();
    }
    
        public function up_test(){
   if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
        $cant_V = 0;
        $cant_A = 0;
        $cant_R = 0;
        $cant_K = 0;

        $cant_G = 0;
        $cant_S = 0;

        for ($i = 1; $i <= 48; $i++) {
            if ($this->input->post($i) == 'V')
                $cant_V++;

            if ($this->input->post($i) == 'A')
                $cant_A++;

            if ($this->input->post($i) == 'R')
                $cant_R++;

            if ($this->input->post($i) == 'K')
                $cant_K++;
        }
        /*
          echo '   Cantidad de V    ';
          echo $cant_V;

          echo '   Cantidad de A    ';
          echo $cant_A;

          echo '   Cantidad de R    ';
          echo $cant_R;

          echo '   Cantidad de K    ';
          echo $cant_K; */

        //GLOBAL _ SECUENCIAL 

        for ($j = 49; $j <= 70; $j++) {
            if ($this->input->post($j) == 'G')
                $cant_G++;
            if ($this->input->post($j) == 'S')
                $cant_S++;
        }

        /* echo "   cantidad G  ";
          echo $cant_G;
          echo "   cantidad S  ";
          echo $cant_S; */



        // $mayor = "";

        $puntaje = 0;
        if ($cant_V >= $cant_A && $cant_V >= $cant_R && $cant_V >= $cant_K) {
            $mayor = 7; //Visual
            $puntaje = $cant_V;
        } else
        if ($cant_A >= $cant_V && $cant_A >= $cant_R && $cant_A >= $cant_K) {
            $mayor = 1; //Auditivo
            $puntaje = $cant_A;
        } else
        if ($cant_R >= $cant_V && $cant_R >= $cant_A && $cant_R >= $cant_K) {
            $mayor = 5; //Lector
            $puntaje = $cant_R;
        } else
        if ($cant_K >= $cant_R && $cant_K >= $cant_V && $cant_K >= $cant_A) {
            $mayor = 3; //kinestesico
            $puntaje = $cant_K;
        }

        if ($cant_G >= $cant_S) {
            $mayor = $mayor + 0; //Global
            $puntaje = $puntaje . '-' . $cant_G;
        } else {
            $mayor = $mayor + 1; //Secuencial
            $puntaje = $puntaje . ' - ' . $cant_S;
        }

   
        $this->usuario_model->update_test($mayor,  $session_data['username']);
        }else{
                        //If no session, redirect to login page
            redirect('init', 'refresh');
            
        }
        
        }
        
        public function up_usr(){
               if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            
            $this->usuario_model->update_usr($session_data['username']);
            //$this->logout();
            
        }else{
                        //If no session, redirect to login page
            redirect('init', 'refresh');
            
        }
        
        }
        
        public function evaluation_user() {
            $id_repository = $this->input->get('idrepository');
            $id_lom = $this->input->get('idlom');
            $pregunta1 = $this->input->get('pregunta1');           
            $pregunta2 = $this->input->get('pregunta2');           
            $pregunta3 = $this->input->get('pregunta3');           
            $pregunta4 = $this->input->get('pregunta4');           
            $pregunta5 = $this->input->get('pregunta5');           
            $pregunta6 = $this->input->get('pregunta6');           
            $pregunta7 = $this->input->get('pregunta7');
            $data = array(
                "id_repository"=> $id_repository,
                "id_lom"=> $id_lom,
                "question_u11"=>$pregunta1,
                "question_u21"=> $pregunta2,
                "question_u31"=> $pregunta3,
                "question_u41" => $pregunta4,
                "question_u51" => $pregunta5,
                "question_u61" => $pregunta6,
                "question_u71" => $pregunta7
            );
            $this->usuario_model->insert_evaluation_user($data);
        }
    
  

}

?>

