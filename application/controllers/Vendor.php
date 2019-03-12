<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Vendor extends CI_Controller{
    public $id_user;
    public $logged_id;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra'); 

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));

        $this->load->model('Vendor_model');
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

        $jumlah_vendor = $this->Vendor_model->total_vendor();
  
        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['vendor'] = $this->Vendor_model->search_vendor($berdasarkan, $string_value);
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
            $config['base_url'] = base_url().'vendor/index/';
            $config['total_rows'] = $jumlah_vendor;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);
            $data['vendor'] = $this->Vendor_model->get_all_vendor_pagination($config['per_page'],$from);
        }
        $data['offset'] = $from;
        
        $data['_view'] = 'vendor/index';
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

        //tabel Vendor
		$this->form_validation->set_rules('no_telp_vendor','No Telp Vendor','numeric|max_length[15]|required');
		$this->form_validation->set_rules('no_telpon','No Telpon','max_length[15]|numeric|required');
		$this->form_validation->set_rules('nama_pemilik_vendor','Nama Pemilik Vendor','max_length[20]|required');
		$this->form_validation->set_rules('nama_vendor','Nama Vendor','max_length[20]|required');
        $this->form_validation->set_rules('alamat','Alamat','');
        //tabel user
        $this->form_validation->set_rules('email','Email','max_length[50]|required');
		$this->form_validation->set_rules('username','Username','max_length[32]|required|alpha_numeric');
		$this->form_validation->set_rules('password','Password','required|max_length[32]|alpha_numeric');
		
		if($this->form_validation->run())     
        {   
            //tabel vendor
            $no_telpon_vendor       = $this->encrypt_aspireone->encode($this->input->post('no_telp_vendor'));
            $no_telpon              = $this->encrypt_aspireone->encode($this->input->post('no_telpon'));
            $nama_pemiliki_vendor   = $this->encrypt_aspireone->encode($this->input->post('nama_pemilik_vendor'));
            $nama_vendor            = $this->encrypt_aspireone->encode($this->input->post('nama_vendor'));
            $alamat            = $this->encrypt_aspireone->encode($this->input->post('alamat'));
            //tabel user
            $username   = $this->encrypt_aspireone->encode($this->input->post('username'));
            $password   = $this->encrypt_aspireone->passwordHash($this->input->post('password'));
            $this->form_validation->set_rules('confpassword','Confirmation Password','max_length[32]|alpha_numeric|matches[password]');
            $email      = $this->encrypt_aspireone->encode($this->input->post('email'));

            $params_user = array(
				'hak_akses' => 'admin_wo',
				'password' => $password,
				'username' => $this->encrypt_aspireone->decode($username),
				'email' => $this->encrypt_aspireone->decode($email),
                'aktif'=>'1'
            );
            $user_id = $this->User_model->add_user($params_user);
            if($user_id > 0){
                $params_vendor = array(
                    'id_user' => $user_id,
                    'nama_vendor' => $this->encrypt_aspireone->decode($nama_vendor),
                    'nama_pemilik_vendor' => $this->encrypt_aspireone->decode($nama_pemiliki_vendor),
                    'no_telpon' => $this->encrypt_aspireone->decode($no_telpon),
                    'no_telp_vendor' => $this->encrypt_aspireone->decode($no_telpon_vendor),
                    'alamat' => $this->encrypt_aspireone->decode($alamat)
                );
                
                $vendor_id = $this->Vendor_model->add_vendor($params_vendor);
                if($vendor_id > 0){
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Account Vendor.</p>');
                    redirect('vendor/index');
                }else{
                    $this->session->set_flashdata('notif_input','<p class="text-danger">Failed Add Account Vendor.</p>');
                    $this->User_model->delete_user($user_id);
                    $data['_view'] = 'vendor/add';
                    $this->load->view('layouts/main',$data);
                }
            }
            
            
        }
        else
        {            
            $data['_view'] = 'vendor/add';
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
        // check if the vendor exists before trying to edit it
        $data['vendor'] = $this->Vendor_model->get_vendor($id_user);
        
        if(isset($data['vendor']['id_user']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('no_telp_vendor','No Telp Vendor','numeric|max_length[15]|required');
			$this->form_validation->set_rules('no_telpon','No Telpon','max_length[15]|numeric|required');
			$this->form_validation->set_rules('nama_pemilik_vendor','Nama Pemilik Vendor','max_length[20]|required');
			$this->form_validation->set_rules('nama_vendor','Nama Vendor','max_length[20]|required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'id_user' => $this->input->post('id_user'),
					'nama_vendor' => $this->input->post('nama_vendor'),
					'nama_pemilik_vendor' => $this->input->post('nama_pemilik_vendor'),
					'no_telpon' => $this->input->post('no_telpon'),
					'no_telp_vendor' => $this->input->post('no_telp_vendor'),
					'alamat' => $this->input->post('alamat'),
                );

                $this->Vendor_model->update_vendor($id_vendor,$params);            
                redirect('vendor/index');
            }
            else
            {
                $data['_view'] = 'vendor/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The vendor you are trying to edit does not exist. '.$id_user);
    } 

    function act_get_vendor(){
        $id_vendor = $this->encrypt_aspireone->decode($this->input->post('id_vendor'));
        echo '
            <table class="table table-bordered">
                <tr>
                    <td>ID Vendor</td>
                    <td align="center">:</td>
                    <td>'.$id_vendor.'</td>
                </tr>
            </table>
        ';
        /*
        $data['vendor'] = $this->Vendor_model->get_vendor($id_vendor);
        if(isset($data['vendor']['id_vendor'])){
            echo '';
        }else{
            echo "false";
        }
        */
    }

    function remove()
    {
        $id_user = $this->encrypt_aspireone->decode($this->input->post('id_user'));
        $vendor = $this->Vendor_model->get_vendor($id_user);
        // check if the vendor exists before trying to delete it
        if(isset($vendor['id_user']))
        {
            $this->session->set_flashdata('notif_input','<p class="text-success">Success Delete Vendor.</p>');
            $this->Vendor_model->delete_vendor($id_user);
            $this->User_model->delete_user($id_user);
            echo "true";
        }
        else
            echo "failed";
            show_error('The vendor you are trying to delete does not exist.');
            
    }
    
}
