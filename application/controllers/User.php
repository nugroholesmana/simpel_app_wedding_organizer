<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class User extends CI_Controller{
    public $id_user;
    public $logged_id;

    function __construct()
    {
        parent::__construct();

        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');        
        

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

        $jumlah_user = $this->User_model->total_user();

        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['user'] = $this->User_model->search_user($berdasarkan, $string_value);
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
            $config['base_url'] = base_url().'user/index/';
            $config['total_rows'] = $jumlah_user;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);
            $data['user'] = $this->User_model->get_all_user_pagination($config['per_page'],$from);
        }
        $data['offset'] = $from;
        $data['_view'] = 'user/index';
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

		$this->form_validation->set_rules('email','Email','max_length[50]|required|is_unique[tbl_datauser.email]');
		$this->form_validation->set_rules('username','Username','max_length[32]|required|alpha_numeric|is_unique[tbl_datauser.username]');
		$this->form_validation->set_rules('password','Password','required|max_length[32]|alpha_numeric');
		
		if($this->form_validation->run())     
        {   
            $username   = $this->encrypt_aspireone->encode($this->input->post('username'));
            $password   = $this->encrypt_aspireone->passwordHash($this->input->post('password'));
            $email      = $this->encrypt_aspireone->encode($this->input->post('email'));

            $params = array(
				'hak_akses' => 'admin',
				'password' => $password,
				'username' => $this->encrypt_aspireone->decode($username),
				'email' => $this->encrypt_aspireone->decode($email),
                'aktif'=>'1'
            );
            
            $id_user = $this->User_model->add_user($params);
            if($id_user > 0){
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Account User.</p>');
                redirect('user/index', 'refresh');
            }else{
                $this->session->set_flashdata('notif_input','<p class="text-danger">Failed Add Account User.</p>');
                $data['_view'] = 'user/add';
                $this->load->view('layouts/main',$data);
            }            
        }
        else
        {            
            $data['_view'] = 'user/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a user
     */
    function edit()
    {   
        $id_user = $this->encrypt_aspireone->decode($this->input->get('q'));

        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        // check if the user exists before trying to edit it
        $data['user'] = $this->User_model->get_user($id_user);
        
        if(isset($data['user']['id_user']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('email','Email','max_length[50]|required|is_unique[tbl_datauser.email]');
			$this->form_validation->set_rules('password','Password','max_length[32]|alpha_numeric');
            $this->form_validation->set_rules('confpassword','Confirmation Password','max_length[32]|alpha_numeric|matches[password]');

            $password   = $this->encrypt_aspireone->encode($this->input->post('password'));
            $email      = $this->encrypt_aspireone->encode($this->input->post('email'));
            
            //checking input password
            if($this->encrypt_aspireone->decode($password) == ""){
                $password = $data['user']['password'];
            }else{
                $password = $this->encrypt_aspireone->decode($password);
                $password = $this->encrypt_aspireone->passwordHash($password);
            }

			if($this->form_validation->run())     
            {   
                $params = array(
					'password' => $password,
					'email' => $this->encrypt_aspireone->decode($email)
                );
                
                $update_account = $this->User_model->update_user($id_user,$params);
                if($update_account){
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Update Account.</p>');         
                    redirect('user/index');
                }else{
                    $this->session->set_flashdata('notif_input','<p class="text-danger">Failed Update Account.</p>');         
                    redirect('user/edit/?q='.urlencode($this->encrypt_aspireone->encode($id_user)));
                }
            }
            else
            {
                $data['_view'] = 'user/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The user you are trying to edit does not exist.');
    } 

    /*
     * Editing a profil logged
     */
    function profile()
    {   
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }

        $data['get_user'] = $this->User_model->get_user($this->id_user);

        // check if the user exists before trying to edit it
        $data['user'] = $this->User_model->get_user($this->id_user);
        
        if(isset($data['user']['id_user']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('email','Email','max_length[50]|required');
			$this->form_validation->set_rules('password','Password','max_length[32]|alpha_numeric');
            $this->form_validation->set_rules('confpassword','Confirmation Password','max_length[32]|alpha_numeric|matches[password]');

            $password   = $this->encrypt_aspireone->encode($this->input->post('password'));
            $email      = $this->encrypt_aspireone->encode($this->input->post('email'));
            
            //checking input password
            if($this->encrypt_aspireone->decode($password) == ""){
                $password = $data['user']['password'];
            }else{
                $password = $this->encrypt_aspireone->decode($password);
                $password = $this->encrypt_aspireone->passwordHash($password);
            }

			if($this->form_validation->run())     
            {   
                $params = array(
					'password' => $password,
					'email' => $this->encrypt_aspireone->decode($email)
                );

                $update_account = $this->User_model->update_user($this->id_user,$params);  
                if($update_account){
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Update Account.</p>');         
                    redirect('user/profile');
                }else{
                    $this->session->set_flashdata('notif_input','<p class="text-danger">Failed Update Account.</p>');         
                    redirect('user/profile');
                }
                
            }
            else
            {
                $data['_view'] = 'user/profile';
                if($data['get_user']['hak_akses'] == 'admin_wo'){
                    $this->load->view('layouts/main_adminwo',$data);                    
                }elseif($data['get_user']['hak_akses'] == 'admin'){
                    $this->load->view('layouts/main',$data);
                }else{
                    show_404();
                }
            }
        }
        else
            show_error('The user you are trying to edit does not exist.');
    }

    function remove()
    {
        $id_user = $this->encrypt_aspireone->decode($this->input->post('id_user'));
        $user = $this->User_model->get_user($id_user);
        // check if the user exists before trying to delete it
        if(isset($user['id_user']))
        {
            $this->session->set_flashdata('notif_input','<p class="text-success">Success Delete Account.</p>');
            $this->User_model->delete_user($id_user);
            echo "true";
        }
        else
            echo "failed";
            show_error('The user you are trying to delete does not exist.');
    }
    
}
