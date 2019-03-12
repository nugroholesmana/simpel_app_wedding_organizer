<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Pelanggan extends CI_Controller{
    public $id_user;
    public $logged_id;
    private $hak_akses;
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');

        $this->load->model('Pelanggan_model');

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));
         $this->hak_akses = $this->encrypt_aspireone->decode($this->session->userdata('hak_akses'));
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

        $jumlah_pelanggan = $this->Pelanggan_model->total_pelanggan();
        
        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['pelanggan'] = $this->Pelanggan_model->search_pelanggan($berdasarkan, $string_value);
            $from = 0;
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
            $config['base_url'] = base_url().'pelanggan/index/';
            $config['total_rows'] = $jumlah_pelanggan;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);  
            $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan_pagination($config['per_page'],$from);
        }
        $data['offset'] = $from;
        
        $data['_view'] = 'pelanggan/index';
        $this->load->view('layouts/main',$data);
    }

    function add()
    {   
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $this->load->library('form_validation');

        //tabel pelanggan
		$this->form_validation->set_rules('nama_pelanggan','Nama Pelanggan','min_length[3]|max_length[50]|required');
		$this->form_validation->set_rules('no_telpon','No Telpon','numeric|required|max_length[15]');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
        //tabel user
        $this->form_validation->set_rules('email','Email','max_length[50]|required');
		$this->form_validation->set_rules('username','Username','max_length[32]|required|alpha_numeric');
		$this->form_validation->set_rules('password','Password','required|max_length[32]|alpha_numeric');
		
		if($this->form_validation->run())     
        {   
           $explode_tgl_lahir = explode("/",$this->input->post('tgl_lahir'));
           $tgl_lahir = $explode_tgl_lahir[2].'-'.$explode_tgl_lahir[1].'-'.$explode_tgl_lahir[0];

            //tabel pelanggan
            $nama_pelanggan     = $this->encrypt_aspireone->encode($this->input->post('nama_pelanggan'));
            $no_telpon          = $this->encrypt_aspireone->encode($this->input->post('no_telpon'));
            $alamat             = $this->encrypt_aspireone->encode($this->input->post('alamat'));
            $tgl_lahir          = $this->encrypt_aspireone->encode($tgl_lahir);
            $jenis_kelamin      = $this->encrypt_aspireone->encode($this->input->post('jenis_kelamin'));
            $token              = $this->encrypt_aspireone->encode(rand(0,100).time().rand(0,100));
            //tabel user
            $username   = $this->encrypt_aspireone->encode($this->input->post('username'));
            $password   = $this->encrypt_aspireone->passwordHash($this->input->post('password'));
            $this->form_validation->set_rules('confpassword','Confirmation Password','max_length[32]|alpha_numeric|matches[password]');
            $email      = $this->encrypt_aspireone->encode($this->input->post('email'));
            
            $params_user = array(
				'hak_akses' => 'pelanggan',
				'password' => $password,
				'username' => $this->encrypt_aspireone->decode($username),
				'email' => $this->encrypt_aspireone->decode($email),
                'aktif'=>'1'
            );
            
            $user_id = $this->User_model->add_user($params_user);            
            if($user_id > 0){
                $params_pelanggan = array(
                    'id_user' => $user_id,
                    'nama_pelanggan' => $this->encrypt_aspireone->decode($nama_pelanggan),
                    'jenis_kelamin' => $this->encrypt_aspireone->decode($jenis_kelamin),
                    'tgl_lahir' => $this->encrypt_aspireone->decode($tgl_lahir),
                    'token' => $token,
                    'no_telpon' => $this->encrypt_aspireone->decode($no_telpon),
                    'alamat' => $this->encrypt_aspireone->decode($alamat)
                );
                $pelanggan_id = $this->Pelanggan_model->add_pelanggan($params_pelanggan);
                if($pelanggan_id > 0){
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Account Pelanggan.</p>');
                    redirect('pelanggan/index');
                }else{
                    $this->session->set_flashdata('notif_input','<p class="text-danger">Failed Add Account Pelanggan.</p>');
                    $this->Pelanggan_model->delete_pelanggan($pelanggan_id);
                    $this->User_model->delete_user($user_id);
                    $data['_view'] = 'pelanggan/add';
                    $this->load->view('layouts/main',$data);
                }                
            }
            
        }
        else
        {            
            $data['_view'] = 'pelanggan/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    function edit()
    {   
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $id_user = $this->encrypt_aspireone->decode($this->input->get('q'));
        // check if the pelanggan exists before trying to edit it
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan($id_user);
        
        if(isset($data['pelanggan']['id_user']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('nama_pelanggan','Nama Pelanggan','min_length[3]|max_length[50]|required');
			$this->form_validation->set_rules('no_telpon','No Telpon','numeric|required|max_length[15]');
			$this->form_validation->set_rules('alamat','Alamat','required');
			$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
		
			if($this->form_validation->run())     
            {   
                $explode_tgl_lahir = explode("/",$this->input->post('tgl_lahir'));
                $tgl_lahir = $explode_tgl_lahir[2].'-'.$explode_tgl_lahir[1].'-'.$explode_tgl_lahir[0];

                $nama_pelanggan     = $this->encrypt_aspireone->encode($this->input->post('nama_pelanggan'));
                $no_telpon          = $this->encrypt_aspireone->encode($this->input->post('no_telpon'));
                $alamat             = $this->encrypt_aspireone->encode($this->input->post('alamat'));
                $tgl_lahir          = $this->encrypt_aspireone->encode($tgl_lahir);
                $jenis_kelamin      = $this->encrypt_aspireone->encode($this->input->post('jenis_kelamin'));
                
                $params = array(
                    'nama_pelanggan' => $this->encrypt_aspireone->decode($nama_pelanggan),
                    'jenis_kelamin' => $this->encrypt_aspireone->decode($jenis_kelamin),
                    'tgl_lahir' => $this->encrypt_aspireone->decode($tgl_lahir),
                    'no_telpon' => $this->encrypt_aspireone->decode($no_telpon),
                    'alamat' => $this->encrypt_aspireone->decode($alamat)
                );
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Update Account Pelanggan.</p>');
                $this->Pelanggan_model->update_pelanggan($id_user,$params);            
                redirect('pelanggan/index');
            }
            else
            {
                $data['_view'] = 'pelanggan/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The pelanggan you are trying to edit does not exist.');
    } 

    function remove()
    {
        $id_user = $this->encrypt_aspireone->decode($this->input->post('id_user'));
        $pelanggan = $this->Pelanggan_model->get_pelanggan($id_user);
        // check if the pelanggan exists before trying to delete it
        if(isset($pelanggan['id_user']))
        {
            
            $this->session->set_flashdata('notif_input','<p class="text-success">Success Delete Pelanggan.</p>');
            $this->Pelanggan_model->delete_pelanggan($id_user);
            $this->User_model->delete_user($id_user);
            echo "true";
        }
        else
            echo "failed";
            show_error('The pelanggan you are trying to delete does not exist.');
    }

    //pelanggan


    function login(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');

        if($this->form_validation->run()){
            $username  = $this->encrypt_aspireone->encode($this->input->post('username'));
            $password  = $this->encrypt_aspireone->encode($this->input->post('password'));
            if($username && $password){
                $get_pelanggan = $this->User_model->check_user(array('username'=>$this->encrypt_aspireone->decode($username)));
                if($get_pelanggan && $get_pelanggan['hak_akses'] == "pelanggan"){
                    $password_verify = $this->encrypt_aspireone->passwordVerify($this->encrypt_aspireone->decode($password), $get_pelanggan['password']);
                    if($password_verify){
                        if($get_pelanggan['aktif'] == "1"){
                            $sess_data = array(
                                'logged_id'=>$this->encrypt_aspireone->encode('pelanggansada'),
                                'id_user'=>$this->encrypt_aspireone->encode($get_pelanggan['id_user']),
                                'hak_akses'=>$this->encrypt_aspireone->encode($get_pelanggan['hak_akses'])
                            );
                            $this->session->set_userdata($sess_data);                        
                            redirect('beranda');
                        }elseif($get_pelanggan['aktif'] == 0){
                            $this->session->set_flashdata('notif_input','<p class="text-danger">Akun tidak aktif.</p>');
                            $data['_view'] = 'pelanggan/login';
                            $this->load->view('layouts/main_pelanggan_one_column',$data);
                        }                                              
                    }else{
                        $this->session->set_flashdata('notif_input','<p class="text-danger">Maaf, Username atau password salah.</p>');
                        $data['_view'] = 'pelanggan/login';
                       $this->load->view('layouts/main_pelanggan_one_column',$data);
                    }
                }else{
                    $this->session->set_flashdata('notif_input','<p class="text-danger">Maaf, Username atau password salah.</p>');
                    $data['_view'] = 'pelanggan/login';
                    $this->load->view('layouts/main_pelanggan_one_column',$data);
                }
            }
        }else{
            $data['_view'] = 'pelanggan/login';
            $this->load->view('layouts/main_pelanggan_one_column',$data);
        }
    }
    public function act_logout_pelanggan(){
        $logged_id = $this->session->userdata('logged_id');
        if($logged_id){
            $this->session->unset_userdata('logged_id');
            $this->session->unset_userdata('id_user');
            $this->session->unset_userdata('hak_akses');
            redirect('pelanggan/login');
        }else{
            echo 'false';
        }
    }

    function pendaftaran(){
        $this->load->library('form_validation');

        //tabel pelanggan
        $this->form_validation->set_rules('nama_pelanggan','Nama Pelanggan','min_length[3]|max_length[50]|required');
		$this->form_validation->set_rules('no_telpon','No Telpon','numeric|required|max_length[15]');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');

        //tabel user
        $this->form_validation->set_rules('email','Email','max_length[80]|required|is_unique[tbl_datauser.email]');
		$this->form_validation->set_rules('username','Username','min_length[5]|max_length[32]|required|alpha_numeric|is_unique[tbl_datauser.username]');
		$this->form_validation->set_rules('password','Password','min_length[6]|required|max_length[32]|alpha_numeric');
        $this->form_validation->set_rules('conpassword','Konfirmasi Password','required|max_length[32]|alpha_numeric|matches[conpassword]');

        if($this->form_validation->run())     
        {  
            $nama_pelanggan = $this->input->post('nama_pelanggan');
            $tgl_lahir      = $this->input->post('tgl_lahir');
            $jenis_kelamin  = $this->input->post('jenis_kelamin');
            $no_telpon      = $this->input->post('no_telpon');
            $alamat         = $this->input->post('alamat');
            $username       = $this->input->post('username');
            $password       = $this->input->post('password');
            $email          = $this->input->post('email');
            $token          = $this->encrypt_aspireone->encode(date('Y-m-d').$username);
            $aktif          = 1;
            $hak_akses      = 'pelanggan';

            $params_user = array(
				'hak_akses' => $hak_akses,
				'password' => $this->encrypt_aspireone->passwordHash($password),
				'username' => $username,
				'email' => $email,
                'aktif'=>$aktif
            );
            
            $user_id = $this->User_model->add_user($params_user);  
            if($user_id > 0){
                $params_pelanggan = array(
                    'id_user' => $user_id,
                    'nama_pelanggan' => $nama_pelanggan,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tgl_lahir' => $tgl_lahir,
                    'token' => $token,
                    'no_telpon' => $no_telpon,
                    'alamat' => $alamat
                );
                $pelanggan_id = $this->Pelanggan_model->add_pelanggan($params_pelanggan);
                if($pelanggan_id > 0){
                    $this->session->set_flashdata('notif_input','<p class="text-success">Pendaftaran Berhasil Silahkan Konfirmasi VIA Email.</p>');
                    redirect('pelanggan/pendaftaran_sukses?key='.urlencode($this->encrypt_aspireone->encode('daftar_berhasil')));
                }else{
                    $this->session->set_flashdata('notif_input','<p class="text-danger">Terjadi Kegagalan.</p>');
                    $this->Pelanggan_model->delete_pelanggan($pelanggan_id);
                    $this->User_model->delete_user($user_id);
                    $data['_view'] = 'pelanggan/pendaftaran';
                    $this->load->view('layouts/main_pelanggan_one_column',$data);
                }
            }
        }else{
                $data['_view'] = 'pelanggan/pendaftaran';
                $this->load->view('layouts/main_pelanggan_one_column',$data);
        }
    }

    function pendaftaran_sukses(){
        /*
            $key = $this->encrypt_aspireone->decode($this->input->get('key'));
            if($key == 'daftar_berhasil'){
                $data['_view'] = 'pelanggan/pendaftaran_sukses';
                $this->load->view('layouts/main_pelanggan_one_column',$data);
            }else{
                show_404();
            }
            */

                $data['_view'] = 'pelanggan/pendaftaran_sukses';
                $this->load->view('layouts/main_pelanggan_one_column',$data);
    }

    public function profilku(){
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($this->hak_akses != "pelanggan"){
            show_404();
        }

            //form data pelanggan
            /*
            $this->form_validation->set_rules('nama_pelanggan','Nama Pelanggan','min_length[3]|max_length[50]|required');
			$this->form_validation->set_rules('no_telpon','No Telpon','numeric|required|max_length[15]');
			$this->form_validation->set_rules('alamat','Alamat','required');
			$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
            //form data user
            $this->form_validation->set_rules('email','Email','max_length[50]|required');
			$this->form_validation->set_rules('password','Password','max_length[32]|alpha_numeric');
            //$this->form_validation->set_rules('confpassword','Confirmation Password','max_length[32]|alpha_numeric|matches[password]');
            */
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_3($this->id_user);
       
            $data['_view'] = 'pelanggan/profilku';
            $this->load->view('layouts/main_pelanggan', $data);
    }

    public function update_profil(){
        $this->load->library('form_validation');
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_3($this->id_user);
            $explode_tgl_lahir = explode("/",$this->input->post('tgl_lahir'));           
            //$tgl_lahir = $explode_tgl_lahir[2].'-'.$explode_tgl_lahir[1].'-'.$explode_tgl_lahir[0]; // urutan tahun-bulan-tanggal
            
            $nama_pelanggan     = $this->input->post('nama_pelanggan');
            $no_telpon          = $this->input->post('no_telepon');
            $alamat             = $this->input->post('alamat');
            $tgl_lahir          = $this->input->post('tgl_lahir');//$tgl_lahir;
            $jenis_kelamin      = $this->input->post('jenis_kelamin');
            
            $email           = $this->input->post('email');
            $password        = $this->input->post('password');
            $conpassword     = $this->input->post('conpassword');      

            
            if($password != $conpassword){
                $this->session->set_flashdata('notif_input', '<p class="text-danger">Konfirmasi password harus sama dengan password.</p>');
                redirect('pelanggan/profilku');
            }elseif(!is_numeric($no_telpon)){
                $this->session->set_flashdata('notif_input', '<p class="text-danger">Nomor telepon harus angka.</p>');
                redirect('pelanggan/profilku');
            }else{
                //checking input password
                if($password == ""){
                    $password = $data['pelanggan']['password'];
                }else{
                    $password = $password;
                    $password = $this->encrypt_aspireone->passwordHash($password);
                }
                $params_pelanggan = array(
                    'nama_pelanggan' => $nama_pelanggan,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tgl_lahir' => $tgl_lahir,
                    'no_telpon' => $no_telpon,
                    'alamat' => $alamat
                );
                $params_user = array(
                        'email' => $email,
                        'password' => $password
                    );
                $update_profil = $this->Pelanggan_model->update_pelanggan($this->id_user, $params_pelanggan);
                $update_user = $this->User_model->update_user($this->id_user, $params_user);
                if($update_profil){
                    $this->session->set_flashdata('notif_input', '<p class="text-success">Berhasil melakukan perubahan data.</p>');
                    redirect('pelanggan/profilku');
                }else{
                    $this->session->set_flashdata('notif_input', '<p class="text-danger">Tidak berhasil melakukan perubahan data.</p>');
                    redirect('pelanggan/profilku');
                }
            }
    }

    function profil_pelanggan(){
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('pelanggan/login');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'pelanggan'){
            show_404();
        }

        $id_user = $this->encrypt_aspireone->decode($this->input->get('q'));
        // check if the pelanggan exists before trying to edit it
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan($id_user);
        
        if(isset($data['pelanggan']['id_user']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('nama_pelanggan','Nama Pelanggan','min_length[3]|max_length[50]|required');
			$this->form_validation->set_rules('no_telpon','No Telpon','numeric|required|max_length[15]');
			$this->form_validation->set_rules('alamat','Alamat','required');
			$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
		
			if($this->form_validation->run())     
            {   
                $explode_tgl_lahir = explode("/",$this->input->post('tgl_lahir'));
                $tgl_lahir = $explode_tgl_lahir[2].'-'.$explode_tgl_lahir[1].'-'.$explode_tgl_lahir[0];

                $nama_pelanggan     = $this->encrypt_aspireone->encode($this->input->post('nama_pelanggan'));
                $no_telpon          = $this->encrypt_aspireone->encode($this->input->post('no_telpon'));
                $alamat             = $this->encrypt_aspireone->encode($this->input->post('alamat'));
                $tgl_lahir          = $this->encrypt_aspireone->encode($tgl_lahir);
                $jenis_kelamin      = $this->encrypt_aspireone->encode($this->input->post('jenis_kelamin'));
                
                $params = array(
                    'nama_pelanggan' => $this->encrypt_aspireone->decode($nama_pelanggan),
                    'jenis_kelamin' => $this->encrypt_aspireone->decode($jenis_kelamin),
                    'tgl_lahir' => $this->encrypt_aspireone->decode($tgl_lahir),
                    'no_telpon' => $this->encrypt_aspireone->decode($no_telpon),
                    'alamat' => $this->encrypt_aspireone->decode($alamat)
                );
                $this->session->set_flashdata('notif_input','<p class="text-success">Sukses melakukan perubahan data diri.</p>');
                $this->Pelanggan_model->update_pelanggan($id_user,$params);            
                redirect('pelanggan/profil');
            }
            else
            {
                $data['_view'] = 'pelanggan/profil';
                $this->load->view('layouts/main_pelanggan',$data);
            }
        }
        else
            show_error('The pelanggan you are trying to edit does not exist.');
    }
    
}
