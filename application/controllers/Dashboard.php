<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Dashboard extends CI_Controller{

    private $id_user;
    private $logged_id;
    private $hak_akses;

    function __construct()
    {
        parent::__construct();
        $this->config->item('globar_var');

        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');  
        
        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));
        $this->hak_akses = $this->encrypt_aspireone->decode($this->session->userdata('hak_akses'));
        
    }
    //halaman utama admin
    function index()
    {
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false ){
            redirect('login/wo_admin');
        }

        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
           show_404();    
        } 
        
        $data['_view'] = 'dashboard';
        $this->load->view('layouts/main',$data);
    }
    //dashboard admin wo
    function admin()
    {
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }

        $data['get_user'] = $this->User_model->get_user($this->id_user);
        
        $data['_view'] = 'dashboard';
        $this->load->view('layouts/main_adminwo',$data);
    }
}
