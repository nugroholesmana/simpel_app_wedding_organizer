<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
class Galeri extends CI_Controller
{
    public $id_user;
    public $logged_id;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');

        $this->load->model('Galeri_model');

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));
    } 

    function index()
    {
        $this->load->library('pagination');

        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $jumlah_galeri = $this->Galeri_model->total_galeri();        
        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['galeri'] = $this->Galeri_model->search_galeri($berdasarkan, $string_value);
        }else{
            /*Class bootstrap pagination yang digunakan*/
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class=' grey active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            $config['base_url'] = base_url().'galeri/index/';
            $config['total_rows'] = $jumlah_galeri;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);  
            $data['galeri'] = $this->Galeri_model->get_all_galeri_pagination($config['per_page'],$from);
            $data['offset'] = $from;
        }
        
        $data['_view'] = 'galeri/index';
        $this->load->view('layouts/main',$data);
    }
    //index galeri untuk hak akses admin
    function galeri_admin()
    {        
        $this->load->model('Vendor_model');
        
        $this->load->library('pagination');

        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->Vendor_model->get_vendor($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin_wo'){
            show_404();
        }

        $jumlah_galeri = $this->Galeri_model->total_galeri_admin($data['get_user']['id_vendor']);   
            /*Class bootstrap pagination yang digunakan*/
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class=' grey active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            $config['base_url'] = base_url().'galeri/galeri_admin/';
            $config['total_rows'] = $jumlah_galeri;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);  
            $data['galeri'] = $this->Galeri_model->get_all_galeri_pagination_admin($data['get_user']['id_vendor'], $config['per_page'],$from);
            $data['offset'] = $from;
        
        $data['_view'] = 'galeri/index_admin';
        $this->load->view('layouts/main_adminwo',$data);
    }

    function add()
    {   
        //load model        
        $this->load->model('Vendor_model');        
        $this->load->library('Oupload');
        
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        
        $data['vendor']     = $this->Vendor_model->get_all_vendor();
        $data['get_user']   = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_vendor','Vendor','required');
		
		if($this->form_validation->run())     
        {   
            $tipe           = $this->encrypt_aspireone->encode($this->input->post('tipe'));
            $id_vendor      = $this->encrypt_aspireone->encode($this->input->post('id_vendor'));
            $foto           = $_FILES['gambar']['name'];

            //Oupload
            $explode            = explode('.', $_FILES['gambar']['name']);
            $ext                = $explode[count($explode)-1];
            $gambar_konten      = $this->encrypt_aspireone->decode($id_vendor).'-'.rand(0,100);
            $gambar_konten_ext  = $gambar_konten.'.'.$ext;
            if($_FILES['gambar']['name'] != ""){
                $gambar_name = $gambar_konten_ext;
            }        

            $this->oupload->setDirectory('files/galeri/');
            $this->oupload->setMaksFile(5000); // max 5mb
            $executeUpload = $this->oupload->proses_upload('gambar',$gambar_konten);
            if($executeUpload)
            {
                $params = array(
                    'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
                    'gambar' => $gambar_name
                );
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Gallery.</p>');
                $paket_id = $this->Galeri_model->add_galeri($params);
                redirect('galeri/index');
            }else{
                $data['_view'] = 'galeri/add';
                $this->load->view('layouts/main',$data);
            }
        }
        else
        {         
            $data['_view'] = 'galeri/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    //add galeri untuk hak akses admin wo
    function galeri_admin_add()
    {   
        //load model        
        $this->load->model('Vendor_model');        
        $this->load->library('Oupload');
        
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        
        $data['vendor']     = $this->Vendor_model->get_all_vendor();
        $data['get_user']   = $this->Vendor_model->get_vendor($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin_wo'){
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_vendor','ID Vendor', 'required');
		
		if($this->form_validation->run())     
        {   
            $id_vendor      = $this->input->post('id_vendor');
            $foto           = $_FILES['gambar']['name'];

            //Oupload
            $explode            = explode('.', $_FILES['gambar']['name']);
            $ext                = $explode[count($explode)-1];
            $gambar_konten      = $this->encrypt_aspireone->decode($id_vendor).'-'.rand(0,100);
            $gambar_konten_ext  = $gambar_konten.'.'.$ext;
            if($_FILES['gambar']['name'] != ""){
                $gambar_name = $gambar_konten_ext;
            }        

            $this->oupload->setDirectory('files/galeri/');
            $this->oupload->setMaksFile(5000); // max 5mb
            $executeUpload = $this->oupload->proses_upload('gambar',$gambar_konten);
            if($executeUpload)
            {
                $params = array(
                    'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
                    'gambar' => $gambar_name
                );
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Gallery.</p>');
                $paket_id = $this->Galeri_model->add_galeri($params);
                redirect('galeri/galeri_admin');
            }else{
                $data['_view'] = 'galeri/add_admin';
                $this->load->view('layouts/main',$data);
            }
        }
        else
        {         
            $data['_view'] = 'galeri/add_admin';
            $this->load->view('layouts/main_adminwo',$data);
        }
    }  

    function remove()
    {
        $id_galeri = $this->encrypt_aspireone->decode($this->input->post('id_galeri'));
        $galeri = $this->Galeri_model->get_galeri($id_galeri);

        // check if the paket exists before trying to delete it
        if(isset($galeri['id_galeri']))
        {
            unlink('files/galeri/'.$paket['gambar']);
            $this->session->set_flashdata('notif_input','<p class="text-success">Success Delete Gallery.</p>');
            $this->Galeri_model->delete_galeri($id_galeri);
            echo "true";
        }
        else
            echo "failed";
            show_error('The Galeri you are trying to delete does not exist.');
    }

    // pelanggan
    function lihat_galeri(){
        $this->load->model('Vendor_model');
        
        $this->load->library('pagination');

        $jumlah_galeri = $this->Galeri_model->total_galeri();   
            /*Class bootstrap pagination yang digunakan*/
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class=' grey active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            $config['base_url'] = base_url().'galeri/lihat_galeri/';
            $config['total_rows'] = $jumlah_galeri;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);  
            $data['get_all_galeri'] = $this->Galeri_model->get_all_galeri_pagination($config['per_page'],$from);
            $data['offset'] = $from;
        
        $data['_view'] = 'galeri/lihat_galeri';
        $this->load->view('layouts/main_pelanggan',$data);
    }
    
}
