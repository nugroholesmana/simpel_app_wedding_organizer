<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    private $id_user;
    private $logged_id;
    private $hak_akses;

    public function __construct()
    {
        parent::__construct();
        //Do your magic here        
        $this->config->load('globals_var');

        $this->load->library('Encrypt_aspireone');  
        $this->load->library('Ekstra');
        
        $this->load->model('User_model'); 

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));  
        $this->hak_akses = $this->encrypt_aspireone->decode($this->session->userdata('hak_akses'));    
    }
    

    public function wo_admin()
    {        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        $key_logged_id = $this->config->item('key_logged_id');
        if($check_logged_id == true && $this->hak_akses == "admin"){
            redirect('dashboard');
        }elseif($check_logged_id == true && $this->hak_akses == "admin_wo"){
            redirect('dashboard/admin');
        }

        $data['get_user'] = $this->User_model->get_user($this->id_user);
        $data['_view'] = 'login';
        $this->load->view('layouts/login',$data);
    }
    
    public function act_login(){      
            $key_logged_id = $this->config->item('key_logged_id'); 

            $username  = $this->encrypt_aspireone->encode($this->input->post('username'));
            $password  = $this->encrypt_aspireone->encode($this->input->post('password'));
            
            if($username && $password){
                $get_user = $this->User_model->check_user(array('username'=>$this->encrypt_aspireone->decode($username)));
                if($get_user && $get_user['hak_akses'] == "admin" || $get_user['hak_akses'] == "admin_wo"){
                    $password_verify = $this->encrypt_aspireone->passwordVerify($this->encrypt_aspireone->decode($password), $get_user['password']);
                    if($password_verify){
                        $sess_data = array(
                            'logged_id'=>$this->encrypt_aspireone->encode($key_logged_id),
                            'id_user'=>$this->encrypt_aspireone->encode($get_user['id_user'])
                        );
                        $this->session->set_userdata($sess_data);      
                        if($get_user['hak_akses'] == "admin"){
                            echo "true_admin";          
                        }elseif($get_user['hak_akses'] == "admin_wo"){
                            echo "true_admin_wo";
                        }                                 
                    }else{
                        echo "false";
                    }
                }else{
                   echo "false";
                }
            }
        
    }

    public function act_logout(){
        $logged_id = $this->session->userdata('logged_id');
        if($logged_id){
            $this->session->unset_userdata('logged_id');
            $this->session->unset_userdata('id_user');
            echo 'true';
        }else{
            echo 'false';
        }
    }

}

