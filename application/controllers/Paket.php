<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Paket extends CI_Controller{
    public $id_user;
    public $logged_id;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');

        $this->load->model('Paket_model');

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));
    } 

    function index()
    {
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $jumlah_paket = $this->Paket_model->total_paket();
          
        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['paket'] = $this->Paket_model->search_paket($berdasarkan, $string_value);
            $data['offset'] = 0;
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
            $config['total_rows'] = $jumlah_paket;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);
            $data['paket'] = $this->Paket_model->get_all_paket_pagination($config['per_page'],$from);
            $data['offset'] = $from;
        }
        $data['_view'] = 'paket/index';
        $this->load->view('layouts/main',$data);
    }
    //index paket untuk hak akses admin wo
    function paket_admin()
    {
        $this->load->model('Vendor_model');
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->Vendor_model->get_vendor($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin_wo'){
            show_404();
        }

        $jumlah_paket = $this->Paket_model->total_paket_admin($data['get_user']['id_vendor']);
          
        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['paket'] = $this->Paket_model->search_paket_admin($data['get_user']['id_vendor'],$berdasarkan, $string_value);
            $data['offset'] = 0;
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
            $config['total_rows'] = $jumlah_paket;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);
            $data['paket'] = $this->Paket_model->get_all_paket_pagination_admin($data['get_user']['id_vendor'],$config['per_page'],$from);
            $data['offset'] = $from;
        }
        $data['_view'] = 'paket/index_admin';
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

        $this->form_validation->set_rules('tipe','Tipe','required');
        $this->form_validation->set_rules('id_vendor','Vendor','required');
		$this->form_validation->set_rules('harga','Harga','max_length[20]|required|numeric');
		$this->form_validation->set_rules('nama_konten','Nama Konten','max_length[50]|required');
		
		if($this->form_validation->run())     
        {   
            $tipe           = $this->encrypt_aspireone->encode($this->input->post('tipe'));
            $id_vendor      = $this->encrypt_aspireone->encode($this->input->post('id_vendor'));
            $nama_konten    = $this->encrypt_aspireone->encode($this->input->post('nama_konten'));
            $harga          = $this->encrypt_aspireone->encode($this->input->post('harga'));
            $foto           = $_FILES['foto']['name'];
            $keterangan     = $this->encrypt_aspireone->encode($this->input->post('keterangan'));

            //Oupload
            $explode        = explode('.', $_FILES['foto']['name']);
            $ext            = $explode[count($explode)-1];
            $foto_konten    = $this->encrypt_aspireone->decode($nama_konten).'-'.$this->encrypt_aspireone->decode($id_vendor).'-'.rand(0,100);
            $foto_konten_ext= $foto_konten.'.'.$ext;
            if($_FILES['foto']['name'] != ""){
                $foto_name = $foto_konten_ext;
            }        

            $this->oupload->setDirectory('files/konten/');
            $this->oupload->setMaksFile(5000); // max 5mb
            $executeUpload = $this->oupload->proses_upload('foto',$foto_konten);
            if($executeUpload)
            {
                $params = array(
                    'tipe' => $this->encrypt_aspireone->decode($tipe),
                    'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
                    'nama_konten' => $this->encrypt_aspireone->decode($nama_konten),
                    'harga' => $this->encrypt_aspireone->decode($harga),
                    'foto' => $foto_name,
                    'keterangan' => $this->encrypt_aspireone->decode($keterangan)
                );
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Paket.</p>');
                $paket_id = $this->Paket_model->add_paket($params);
                redirect('paket/index');
            }else{
                $data['_view'] = 'paket/add';
                $this->load->view('layouts/main',$data);
            }
        }
        else
        {         
            $data['_view'] = 'paket/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    //add untuk admin wo
    function paket_admin_add()
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

        $this->form_validation->set_rules('tipe','Tipe','required');
		$this->form_validation->set_rules('harga','Harga','max_length[20]|required|numeric');
		$this->form_validation->set_rules('nama_konten','Nama Konten','max_length[50]|required');
		
		if($this->form_validation->run())     
        {   
            $tipe           = $this->encrypt_aspireone->encode($this->input->post('tipe'));
            $id_vendor      = $this->encrypt_aspireone->encode($data['get_user']['id_vendor']);
            $nama_konten    = $this->encrypt_aspireone->encode($this->input->post('nama_konten'));
            $harga          = $this->encrypt_aspireone->encode($this->input->post('harga'));
            $foto           = $_FILES['foto']['name'];
            $keterangan     = $this->encrypt_aspireone->encode($this->input->post('keterangan'));

            //Oupload
            $explode        = explode('.', $_FILES['foto']['name']);
            $ext            = $explode[count($explode)-1];
            $foto_konten    = $this->encrypt_aspireone->decode($nama_konten).'-'.$this->encrypt_aspireone->decode($id_vendor).'-'.rand(0,100);
            $foto_konten_ext= $foto_konten.'.'.$ext;
            if($_FILES['foto']['name'] != ""){
                $foto_name = $foto_konten_ext;
            }        

            $this->oupload->setDirectory('files/konten/');
            $this->oupload->setMaksFile(5000); // max 5mb
            $executeUpload = $this->oupload->proses_upload('foto',$foto_konten);
            if($executeUpload)
            {
                $params = array(
                    'tipe' => $this->encrypt_aspireone->decode($tipe),
                    'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
                    'nama_konten' => $this->encrypt_aspireone->decode($nama_konten),
                    'harga' => $this->encrypt_aspireone->decode($harga),
                    'foto' => $foto_name,
                    'keterangan' => $this->encrypt_aspireone->decode($keterangan)
                );
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Paket.</p>');
                $paket_id = $this->Paket_model->add_paket($params);
                redirect('paket/paket_admin');
            }else{
                $data['_view'] = 'paket/add_admin';
                $this->load->view('layouts/main_adminwo',$data);
            }
        }
        else
        {         
            $data['_view'] = 'paket/add_admin';
            $this->load->view('layouts/main_adminwo',$data);
        }
    } 

    function edit()
    {   
        
        $this->load->model('Vendor_model');
        $this->load->library('Oupload');
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $id_konten = $this->encrypt_aspireone->decode($this->input->get('q'));

        // check if the paket exists before trying to edit it
        $data['vendor']     = $this->Vendor_model->get_all_vendor();
        $data['paket'] = $this->Paket_model->get_paket($id_konten);
        
        if(isset($data['paket']['id_konten']))
        {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('foto','Foto');
                $this->form_validation->set_rules('tipe','Tipe','required');
                $this->form_validation->set_rules('id_vendor','Vendor','required');
                $this->form_validation->set_rules('harga','Harga','max_length[20]|required|numeric');
                $this->form_validation->set_rules('nama_konten','Nama Konten','max_length[50]|required|alpha');
            
            if($this->form_validation->run())     
            {   
                $tipe           = $this->encrypt_aspireone->encode($this->input->post('tipe'));
                $id_vendor      = $this->encrypt_aspireone->encode($this->input->post('id_vendor'));
                $nama_konten    = $this->encrypt_aspireone->encode($this->input->post('nama_konten'));
                $harga          = $this->encrypt_aspireone->encode($this->input->post('harga'));
                $foto           = $_FILES['foto']['name'];
                $keterangan     = $this->encrypt_aspireone->encode($this->input->post('keterangan'));

                //Oupload
                $explode        = explode('.', $_FILES['foto']['name']);
                $ext            = $explode[count($explode)-1];
                $foto_konten    = $this->encrypt_aspireone->decode($nama_konten).'-'.$this->encrypt_aspireone->decode($id_vendor).'-'.rand(0,100);
                $foto_konten_ext= $foto_konten.'.'.$ext;
                if($_FILES['foto']['name'] != ""){
                    $foto_name = $foto_konten_ext;
                    $this->oupload->setDirectory('files/konten/');
                    $this->oupload->setMaksFile(5000); // max 5mb
                    $executeUpload = $this->oupload->proses_upload('foto',$foto_konten);
                }else{
                    $foto_name = $data['paket']['foto'];
                    $executeUpload = true;
                }        
                if($executeUpload){
                    $params = array(
                        'tipe' => $this->encrypt_aspireone->decode($tipe),
                        'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
                        'nama_konten' => $this->encrypt_aspireone->decode($nama_konten),
                        'harga' => $this->encrypt_aspireone->decode($harga),
                        'foto' => $foto_name,
                        'keterangan' => $this->encrypt_aspireone->decode($keterangan),
                    );
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Update Paket.</p>');
                    $this->Paket_model->update_paket($id_konten,$params);            
                    redirect('paket/index');
                }
                
            }
            else
            {
                $data['_view'] = 'paket/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The paket you are trying to edit does not exist.'.$id_konten);
    } 

    //edit paket untuk admin wo 
    function paket_admin_edit()
    {   
        
        $this->load->model('Vendor_model');
        $this->load->library('Oupload');
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->Vendor_model->get_vendor($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin_wo'){
            show_404();
        }

        $id_konten = $this->encrypt_aspireone->decode($this->input->get('q'));

        // check if the paket exists before trying to edit it
        $data['vendor']     = $this->Vendor_model->get_all_vendor();
        $data['paket'] = $this->Paket_model->get_paket($id_konten);
        
        if(isset($data['paket']['id_konten']))
        {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('foto','Foto');
                $this->form_validation->set_rules('tipe','Tipe','required');
                $this->form_validation->set_rules('harga','Harga','max_length[20]|required|numeric');
                $this->form_validation->set_rules('nama_konten','Nama Konten','max_length[50]|required|alpha');
            
            if($this->form_validation->run())     
            {   
                $tipe           = $this->encrypt_aspireone->encode($this->input->post('tipe'));
                $nama_konten    = $this->encrypt_aspireone->encode($this->input->post('nama_konten'));
                $harga          = $this->encrypt_aspireone->encode($this->input->post('harga'));
                $foto           = $_FILES['foto']['name'];
                $keterangan     = $this->encrypt_aspireone->encode($this->input->post('keterangan'));

                //Oupload
                $explode        = explode('.', $_FILES['foto']['name']);
                $ext            = $explode[count($explode)-1];
                $foto_konten    = $this->encrypt_aspireone->decode($nama_konten).'-'.$this->encrypt_aspireone->decode($id_vendor).'-'.rand(0,100);
                $foto_konten_ext= $foto_konten.'.'.$ext;
                if($_FILES['foto']['name'] != ""){
                    $foto_name = $foto_konten_ext;
                    $this->oupload->setDirectory('files/konten/');
                    $this->oupload->setMaksFile(5000); // max 5mb
                    $executeUpload = $this->oupload->proses_upload('foto',$foto_konten);
                }else{
                    $foto_name = $data['paket']['foto'];
                    $executeUpload = true;
                }        
                if($executeUpload){
                    $params = array(
                        'tipe' => $this->encrypt_aspireone->decode($tipe),
                        'nama_konten' => $this->encrypt_aspireone->decode($nama_konten),
                        'harga' => $this->encrypt_aspireone->decode($harga),
                        'foto' => $foto_name,
                        'keterangan' => $this->encrypt_aspireone->decode($keterangan),
                    );
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Update Paket.</p>');
                    $this->Paket_model->update_paket($id_konten,$params);            
                    redirect('paket/paket_admin');
                }
                
            }
            else
            {
                $data['_view'] = 'paket/edit_admin';
                $this->load->view('layouts/main_adminwo',$data);
            }
        }
        else
            show_error('The paket you are trying to edit does not exist.'.$id_konten);
    } 

    function get_paket_utama(){
        $id_vendor  = $this->input->post('id_vendor');
        $tipe       = 1; //tipe paket utama
        $this->load->model('Paket_model');

        $vendor = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        
        echo '<select name="paket[0]" id="id_paket" class="form-control" required>';
        if($vendor){
            echo '<option value="">Pilih Paket</option>';
            foreach($vendor as $value)
            {
                $selected = ($value['id_konten'] == $this->input->post('id_konten')) ? ' selected="selected"' : "";
                echo '<option value="'.$value['id_konten'].'" '.$selected.'>'.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</option>';
            } 
        }else{
            echo '<option value="">Paket tidak tersedia</option>';
        }
        echo '</select>';
    }

    function get_paket_catering(){
        $id_vendor  = $this->input->post('id_vendor');
        $tipe       = 2; //tipe catering
        $this->load->model('Paket_model');

        $vendor = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        
        echo '<select name="paket[1]" id="id_catering" class="form-control">';
        if($vendor){
            echo '<option value="">Pilih Paket Catering</option>';
            foreach($vendor as $value)
            {
                $selected = ($value['id_konten'] == $this->input->post('id_konten')) ? ' selected="selected"' : "";
                echo '<option value="'.$value['id_konten'].'" '.$selected.'>'.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</option>';
            } 
        }else{
            echo '<option value="">Catering tidak tersedia</option>';
        }
        echo '</select>';
    }

    function get_paket_ekstra(){
        $id_vendor  = $this->input->post('id_vendor');
        $tipe       = 3; //tipe paket ekstra
        $this->load->model('Paket_model');

        $vendor = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        foreach($vendor as $value)
        {
            echo '<div class="form-group">';
            echo '<input type="checkbox" name="paket_ekstra[]" value="'.$value['id_konten'].'"  id="id_paket '.$value['id_konten'].'" />';
            echo '<label for="'.$value['id_konten'].'" class="control-label"> '.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</label>';
            echo '</div>';
        } 
    }

    function get_paket_ekstra2(){
        $id_vendor  = $this->input->post('id_vendor');
        $tipe       = 3; //tipe paket ekstra
        $this->load->model('Paket_model');

        $vendor = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        //echo '<script>var total_ekstra = 0;</script>';
        foreach($vendor as $value)
        {
            echo '<div class="form-group">';
            echo '<input type="checkbox" name="paket_ekstra[]" value="'.$value['id_konten'].'"  id="id_paket'.$value['id_konten'].'" />';
            echo '<label for="'.$value['id_konten'].'" class="control-label"> '.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</label>';
            echo '</div>';
            echo '
                <script>                                    
                var nm_pkt;
                var total_ekstra = 0;
                var harga_ekstra;
                $("#id_paket'.$value['id_konten'].'").click(function(){ 
                    if(this.checked == true) {
                        $.ajax({
                                    type: "POST",
                                    data: "id_konten="+$("#id_paket'.$value['id_konten'].'").val(),
                                    url: "'.site_url("paket/tampilkan_nama_paket").'",
                                    success:function(msgl){                                     
                                        $( "#val_ekstra" ).append("<span class=eks'.$value['id_konten'].'> "+ msgl + ", </span>");
                                    }
                                });
                        $.ajax({
                                    type: "POST",
                                    data: "id_konten="+$("#id_paket'.$value['id_konten'].'").val(),
                                    url: "'.site_url("paket/tampilkan_harga_paket").'",
                                    success:function(msgl){
                                        $( "#val_harga_ekstra" ).append("<span class=eks'.$value['id_konten'].'>Rp "+ msgl + ", </span>");       
                                        harga_ekstra = parseInt(msgl);
                                        total_ekstra += parseInt(harga_ekstra);
                                        total_harga = total_ekstra + parseInt($("#pkt_utama").val()) + parseInt($("#pkt_catering").val());
                                        $("#val_total_harga").html(total_harga); 
                                        console.log($("#val_harga_paket_utama").val());
                                    }
                                }); 
                    }else{
                        $.ajax({
                                    type: "POST",
                                    data: "id_konten="+$("#id_paket'.$value['id_konten'].'").val(),
                                    url: "'.site_url("paket/tampilkan_harga_paket").'",
                                    success:function(msgl){                                        
                                        $( ".eks'.$value['id_konten'].'" ).remove();       
                                        harga_ekstra = parseInt(msgl);
                                        total_ekstra -= parseInt(harga_ekstra);
                                        total_harga = total_ekstra + parseInt($("#pkt_utama").val()) + parseInt($("#pkt_catering").val());
                                        $("#val_total_harga").html(total_harga); 
                                    }
                                });
                        }   
                });
                </script>
            ';
            //$("#val_ekstra").html(msgl);
        }   
    }

    /*
     * Deleting paket
     */
    function remove()
    {
        $id_konten = $this->encrypt_aspireone->decode($this->input->post('id_konten'));
        $paket = $this->Paket_model->get_paket($id_konten);

        // check if the paket exists before trying to delete it
        if(isset($paket['id_konten']))
        {
            unlink('files/konten/'.$paket['foto']);
            $this->session->set_flashdata('notif_input','<p class="text-success">Success Delete Paket.</p>');
            $this->Paket_model->delete_paket($id_konten);
            echo "true";
        }
        else
            echo "failed";
            show_error('The paket you are trying to delete does not exist.');
    }

    //PELANGGAN
    function menu_paket($id_vendor){
        $this->load->model('Vendor_model');
        $data['g_paket'] = $this->Paket_model->g_paket($id_vendor);
        $data['g_vendor'] = $this->Vendor_model->get_vendor_2($id_vendor);
        $data['_view'] = 'paket/single_paket';
        $this->load->view('layouts/main_pelanggan',$data);
    }
    function tampilkan_nama_paket(){
        $id_konten = $this->input->post('id_konten');
        $data['g_paket'] = $this->Paket_model->get_paket($id_konten);
        echo $data['g_paket']['nama_konten'];
    }
    function tampilkan_harga_paket(){
        $id_konten = $this->input->post('id_konten');
        $data['g_paket'] = $this->Paket_model->get_paket($id_konten);
        echo $data['g_paket']['harga'];
    }
    function tampilkan_list_nama_paket(){
        $id_konten = $this->input->post('id_konten');
        for($i=0;  $i<count($id_konten); $i++){
            $data['g_paket'] = $this->Paket_model->get_paket($id_konten[$i]);
            $nm_paket_ekstra[] = $data['g_paket']['nama_konten'];
        }
        $implode_nm_paket_ekstra = implode(', ',$nm_paket_ekstra);
        $dataPaketEkstra = array('nama'=>$implode_nm_paket_ekstra);
        echo json_encode($dataPaketEkstra);
    }
}
