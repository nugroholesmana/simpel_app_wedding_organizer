<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Pesanan extends CI_Controller{
    public $id_user;
    public $logged_id;
    private $hak_akses;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');

        $this->load->model('Pesanan_model');

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));
        $this->hak_akses = $this->encrypt_aspireone->decode($this->session->userdata('hak_akses'));
    } 

    /*
     * Listing of pesanan
     */
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

        $jumlah_pesanan = $this->Pesanan_model->total_pesanan();
        
        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        if($berdasarkan && $string_value){
            $data['pesanan'] = $this->Pesanan_model->search_pesanan($berdasarkan, $string_value);
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
            $config['base_url'] = base_url().'pesanan/index/';
            $config['total_rows'] = $jumlah_pesanan;
            $config['per_page'] = 15;
            $from = $this->uri->segment(3);
            $this->pagination->initialize($config);  
            $data['pesanan'] = $this->Pesanan_model->get_all_pesanan_pagination($config['per_page'],$from);
        }
        $data['offset'] = $from;
        
        $data['_view'] = 'pesanan/index';
        $this->load->view('layouts/main',$data);
    }

    function add()
    {   
        
        $this->load->model('Pesanan_detail_model');
        $this->load->model('Pembayaran_model');
        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $this->load->model('Pelanggan_model');
        $this->load->model('Vendor_model');
        $this->load->model('Pesanan_detail_model');
        $this->load->model('Pembayaran_model');
        $this->load->model('Paket_model');
        
        $data['pelanggan']  = $this->Pelanggan_model->get_all_pelanggan();
        $data['vendor']     = $this->Vendor_model->get_all_Vendor();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pelanggan','Pelanggan','required');
        $this->form_validation->set_rules('id_vendor','Vendor','required');
        $this->form_validation->set_rules('tgl_resepsi','Tanggal Resepsi','required');
        $this->form_validation->set_rules('jumlah_tamu','Jumlah Tamu');
        $this->form_validation->set_rules('paket[0]','Paket','required');
        $this->form_validation->set_rules('paket_ekstra','Paket Ekstra');
		
		if($this->form_validation->run())     
        {   
            $id_pelanggan   = $this->encrypt_aspireone->encode($this->input->post('id_pelanggan'));
            $id_vendor      = $this->encrypt_aspireone->encode($this->input->post('id_vendor'));
            $value_tgl_resepsi    = $this->encrypt_aspireone->encode($this->input->post('tgl_resepsi'));
            $jumlah_tamu          = $this->input->post('jumlah_tamu');
            $paket          = $this->input->post('paket');
            $paket_ekstra   = $this->input->post('paket_ekstra');
            $explode_tgl_resepsi   = explode('/',$this->encrypt_aspireone->decode($value_tgl_resepsi));
            $tgl_resepsi = $explode_tgl_resepsi[2].'-'.$explode_tgl_resepsi[1].'-'.$explode_tgl_resepsi[0];
                        
            $params = array(
				'id_pelanggan' => $this->encrypt_aspireone->decode($id_pelanggan),
				'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
				'tgl_resepsi' => $tgl_resepsi,
                'jumlah_tamu'=>$jumlah_tamu
            );
            
            $pesanan_id = $this->Pesanan_model->add_pesanan($params);
            $total_pembayaran = 0;
            if($pesanan_id > 0){

                    $get_harga = $this->Paket_model->get_harga_paket($paket[0]);
                    $sub_pembayaran += $get_harga['harga'];
                    $get_harga_catering = $this->Paket_model->get_harga_paket($paket[1]);
                    $sub_pembayaran_catering += $get_harga_catering['harga'] * $jumlah_tamu;
                for($i = 0; $i < count($paket); $i++){
                    $params_detail_pesanan[$i] = array(
                    'id_pesanan'=>$pesanan_id,
                    'id_paket'=>$paket[$i]
                    );
                };
                if(count($paket_ekstra)>0){
                    for($i = 0; $i < count($paket_ekstra); $i++){
                        $params_detail_pesanan2[$i] = array(
                        'id_pesanan'=>$pesanan_id,
                        'id_paket'=>$paket_ekstra[$i]
                        );
                        $get_harga = $this->Paket_model->get_harga_paket($paket_ekstra[$i]);
                        $sub_pembayaran1 += $get_harga['harga'];
                    };
                $this->Pesanan_detail_model->add_pesanan_detail($params_detail_pesanan2);
                }else{
                    $sub_pembayaran1 = 0;
                }
                $total_pembayaran = $sub_pembayaran + $sub_pembayaran_catering + $sub_pembayaran1;
                $params_pembayaran = array(
                    'id_pesanan'=>$pesanan_id,
                    'total_pembayaran'=>$total_pembayaran,
                    'status'=>2
                );
                $this->Pembayaran_model->add_pembayaran($params_pembayaran);
                $this->Pesanan_detail_model->add_pesanan_detail($params_detail_pesanan);
                //echo number_format($total_pembayaran);
                
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Pesanan.</p>');
                redirect('pesanan/index');
            }            
        }
        else
        {            

            $data['_view'] = 'pesanan/add';
            $this->load->view('layouts/main',$data);
        }
    }  
    
    function check_transaksi()
    {           
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }
        
        $this->load->model('Pelanggan_model');
        $this->load->model('Vendor_model');
        $this->load->model('Paket_model');
		
        $id_pelanggan   = $this->input->post('id_pelanggan');
        $id_vendor      = $this->input->post('id_vendor');
        $tgl_resepsi    = $this->input->post('tgl_resepsi');
        $jumlah_tamu    = $this->input->post('jumlah_tamu');
        $paket          = $this->input->post('paket');
        $paket_ekstra   = @$this->input->post('paket_ekstra');
        //get pelanggan
        $get_pelanggan      = $this->Pelanggan_model->get_pelanggan_2($id_pelanggan);
        $get_vendor         = $this->Vendor_model->get_vendor_2($id_vendor);
        $get_paket_utama    = $this->Paket_model->get_paket($paket[0]);
        $get_paket_catering = $this->Paket_model->get_paket($paket[1]);
        $total_ekstra = 0;
        if(count($paket_ekstra) > 0){
            for($i=0;  $i<count($paket_ekstra); $i++){
                $get_paket_ekstra = $this->Paket_model->get_paket($paket_ekstra[$i]);
                //$dataPaketEkstra[] = array('nama'=>$get_paket_ekstra['nama_konten'], 'harga'=>$get_paket_ekstra['harga']);
                $total_ekstra += $get_paket_ekstra['harga'];
                $nm_paket_ekstra[] = $get_paket_ekstra['nama_konten'];
            }
            $implode_nm_paket_ekstra = implode(', ',$nm_paket_ekstra);
            $dataPaketEkstra = array('nama'=>$implode_nm_paket_ekstra, 'harga'=>number_format($total_ekstra));
        }else{
            $dataPaketEkstra = array('nama'=>null, 'harga'=>0);
        }
        $total_harga_catering = $get_paket_catering['harga'] * $jumlah_tamu;
        $total = $get_paket_utama['harga'] + $total_harga_catering + $total_ekstra;
        $jsonMSG = array(
            'nm_pelanggan'=>$get_pelanggan['nama_pelanggan'],
            'nm_vendor'=>$get_vendor['nama_vendor'],
            'tgl_resepsi'=>$tgl_resepsi,
            'jumlah_tamu'=>$jumlah_tamu,
            'paket_utama'=>array('nama'=>$get_paket_utama['nama_konten'],'harga'=>number_format($get_paket_utama['harga'])),
            'paket_catering'=>array('nama'=>$get_paket_catering['nama_konten']." - Rp ".number_format($get_paket_catering['harga'])." / Orang",'harga'=>number_format($total_harga_catering)),
            'paket_ekstra'=>$dataPaketEkstra,
            'total'=> number_format($total)
        );
        echo json_encode($jsonMSG);
    }
    function konfirmasi(){
        
        $this->load->model('Pembayaran_model');
        $this->load->model('Pesanan_detail_model');
        
        $id_pesanan = $this->encrypt_aspireone->decode($this->input->get('q'));

        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $pesanan_detail = $this->Pesanan_detail_model->get_all_pesanan_detail($id_pesanan);
        foreach($pesanan_detail as $result){
            $paketResult[] = $result['nama_konten'];
        }
        $data['pesanan_detail'] = implode(', ',$paketResult);
        $data['pesanan'] = $this->Pesanan_model->get_pesanan($id_pesanan);

        if(isset($data['pesanan']['id_pesanan'])){            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('status','Status','numeric|required');

            if($this->form_validation->run()){
                $status = $this->encrypt_aspireone->encode($this->input->post('status'));
                $params = array(
                    'status'=> $this->encrypt_aspireone->decode($status)
                );
                $this->Pembayaran_model->update_pembayaran($id_pesanan,$params);
                $this->session->set_flashdata('notif_input','<p class="text-success">Sukses Ubah Data Konfirmasi Pesanan Dengan ID : '.$id_pesanan.'</p>');
                redirect('pesanan');
            }else{
                $data['_view'] = 'pesanan/konfirmasi';
                $this->load->view('layouts/main',$data);
            }
        }else{
            $this->session->set_flashdata('notif_input','<p class="text-danger">ID Pesanan: '.$id_pesanan.' Tidak Valid</p>');
            redirect('pesanan');
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

        $id_pesanan = $this->encrypt_aspireone->decode($this->input->get('q'));       

        $this->load->model('Pelanggan_model');
        $this->load->model('Vendor_model');
        $this->load->model('Pesanan_detail_model');
        $this->load->model('Pembayaran_model');
        $this->load->model('Paket_model');
        
        $data['pelanggan']  = $this->Pelanggan_model->get_all_pelanggan();
        $data['vendor']     = $this->Vendor_model->get_all_Vendor();
        $data['pesanan']    = $this->Pesanan_model->get_pesanan($id_pesanan);
        
        if(isset($data['pesanan']['id_pesanan']))
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('id_pelanggan','Pelanggan','required');
            $this->form_validation->set_rules('id_vendor','Vendor','required');
            $this->form_validation->set_rules('tgl_resepsi','Tanggal Resepsi','required');
            $this->form_validation->set_rules('paket[0]','Paket','required');
            $this->form_validation->set_rules('paket_ekstra','Paket Ekstra');
		
			if($this->form_validation->run())     
            {   
                $id_pelanggan   = $this->encrypt_aspireone->encode($this->input->post('id_pelanggan'));
                $id_vendor      = $this->encrypt_aspireone->encode($this->input->post('id_vendor'));
                $value_tgl_resepsi    = $this->encrypt_aspireone->encode($this->input->post('tgl_resepsi'));
                $paket          = $this->input->post('paket');
                $paket_ekstra   = $this->input->post('paket_ekstra');
                $explode_tgl_resepsi   = explode('/',$this->encrypt_aspireone->decode($value_tgl_resepsi));
                $tgl_resepsi = $explode_tgl_resepsi[2].'-'.$explode_tgl_resepsi[1].'-'.$explode_tgl_resepsi[0];

                $params = array(
                    'id_pelanggan' => $this->encrypt_aspireone->decode($id_pelanggan),
                    'id_vendor' => $this->encrypt_aspireone->decode($id_vendor),
                    'tgl_resepsi' => $tgl_resepsi,
                );
                
                $pesanan_id = $this->Pesanan_model->update_pesanan($id_pesanan, $params);
                $total_pembayaran = 0;

                if($pesanan_id){
                    $this->Pesanan_detail_model->delete_pesanan_detail($id_pesanan);
                    for($i = 0; $i < count($paket); $i++){
                        $params_detail_pesanan[$i] = array(
                        'id_pesanan'=>$id_pesanan,
                        'id_paket'=>$paket[$i]
                        );
                        $get_harga = $this->Paket_model->get_harga_paket($paket[$i]);
                        $sub_pembayaran += $get_harga['harga'];
                    };
                    if(count($paket_ekstra)>0){
                        for($i = 0; $i < count($paket_ekstra); $i++){
                            $params_detail_pesanan2[$i] = array(
                            'id_pesanan'=>$id_pesanan,
                            'id_paket'=>$paket_ekstra[$i]
                            );
                            $get_harga = $this->Paket_model->get_harga_paket($paket_ekstra[$i]);
                            $sub_pembayaran1 += $get_harga['harga'];
                        };
                        $this->Pesanan_detail_model->add_pesanan_detail($params_detail_pesanan2);
                    }else{
                        $sub_pembayaran1 = 0;
                    }
                    $total_pembayaran = $sub_pembayaran + $sub_pembayaran1;
                    $params_pembayaran = array(
                        'total_pembayaran'=>$total_pembayaran,
                        'status'=>2
                    );
                    $this->Pembayaran_model->update_pembayaran($id_pesanan, $params_pembayaran);
                    $this->Pesanan_detail_model->add_pesanan_detail($params_detail_pesanan);
                    //echo number_format($total_pembayaran);
                    
                    $this->session->set_flashdata('notif_input','<p class="text-success">Success Update Pesanan.</p>');
                    redirect('pesanan/index');
                }
            }
            else
            {
                $data['_view'] = 'pesanan/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The pesanan you are trying to edit does not exist.');
    } 

    function get_pesanan_paket_utama(){
        $id_vendor  = $this->input->post('id_vendor');
        $id_pesanan  = $this->input->post('id_pesanan');

        $tipe       = 1; //tipe paket utama
        $this->load->model('Paket_model');
        $this->load->model('Pesanan_detail_model');

        $vendor     = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        $pesanan    = $this->Pesanan_detail_model->get_pesanan_detail($id_pesanan, $tipe);
        
        echo '<select name="paket[0]" id="id_paket" class="form-control">';
        if($vendor){
            echo '<option value="">Pilih Paket</option>';
            foreach($vendor as $value)
            {
                $selected = ($value['id_konten'] == $pesanan['id_konten']) ? ' selected="selected"' : $this->input->post('id_konten');
                echo '<option value="'.$value['id_konten'].'" '.$selected.'>'.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</option>';
            } 
        }else{
            echo '<option value="">Paket tidak tersedia</option>';
        }
        echo '</select>';
    }
    function get_pesanan_paket_catering(){
        $id_vendor  = $this->input->post('id_vendor');
        $id_pesanan  = $this->input->post('id_pesanan');

        $tipe       = 2; //tipe catering
        $this->load->model('Paket_model');
        $this->load->model('Pesanan_detail_model');

        $vendor = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        $pesanan    = $this->Pesanan_detail_model->get_pesanan_detail($id_pesanan, $tipe);
        
        echo '<select name="paket[1]" id="id_catering id_paket" class="form-control">';
        if($vendor){
            echo '<option value="">Pilih Paket</option>';
            foreach($vendor as $value)
            {
                $selected = ($value['id_konten'] == $pesanan['id_konten']) ? ' selected="selected"' : $this->input->post('id_konten');
                echo '<option value="'.$value['id_konten'].'" '.$selected.'>'.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</option>';
            } 
        }else{
            echo '<option value="">Catering tidak tersedia</option>';
        }
        echo '</select>';
    }

    function get_pesanan_paket_ekstra(){
        $id_vendor  = $this->input->post('id_vendor');
        $tipe       = 3; //tipe paket ekstra
        $this->load->model('Paket_model');
        $this->load->model('Pesanan_detail_model');
        $id_pesanan  = $this->input->post('id_pesanan');

        $vendor = $this->Paket_model->get_all_paket_pertipe($id_vendor,$tipe);
        foreach($vendor as $value)
        {
            $pesanan    = $this->Pesanan_detail_model->get_pesanan_detail_2($id_pesanan, $value['id_konten']);
            echo '<div class="form-group">';
            echo '<input type="checkbox" name="paket_ekstra[]" value="'.$value['id_konten'].'"  id="id_paket '.$value['id_konten'].'" '.($value['id_konten']==$pesanan['id_konten'] ? 'checked="checked"' : '').' />';
            echo '<label for="'.$value['id_konten'].'" class="control-label"> '.$value['nama_konten'].' - Rp '.number_format($value['harga']).'</label>';
            echo '</div>';
        } 
    }

    function remove()
    {
        $id_pesanan = $this->encrypt_aspireone->decode($this->input->post('id_pesanan'));
        $pesanan = $this->Pesanan_model->get_pesanan($id_pesanan);

        // check if the pesanan exists before trying to delete it
        if(isset($pesanan['id_pesanan']))
        {
            echo 'true';
            $this->session->set_flashdata('notif_input','<p class="text-success">Success Delete Pesanan.</p>');
            $this->Pesanan_model->delete_pesanan($id_pesanan);
            //redirect('pesanan/index');
        }
        else
            show_error('The pesanan you are trying to delete does not exist.');
    }
// khusus pelanggan
    function pesan_sekarang($id_vendor){
        $this->load->model('Vendor_model');
        $data['vendor'] = $this->Vendor_model->get_vendor_2($id_vendor);
        if($this->logged_id && $this->hak_akses == "pelanggan"){
            $data['_view'] = 'pesanan/pesan_sekarang';
            $this->load->view('layouts/main_pelanggan',$data);
        }else{
            $this->session->set_flashdata("notif_input", "<p class='text-danger'>Maaf anda harus login terlebih dahulu sebagai pelanggan.</p>");
            redirect('paket/menu_paket/'.$id_vendor);
        }
    }
    function act_pesan_sekarang(){
        $this->load->model('Pesanan_detail_model');
        $this->load->model('Pembayaran_model');
        $this->load->model('Paket_model');
        $this->load->model('Pelanggan_model');
        $get_datapelanggan = $this->Pelanggan_model->get_pelanggan($this->id_user);

        $id_pelanggan   = $get_datapelanggan['id_pelanggan'];
        $id_vendor      = $this->input->post('id_vendor');
        $tgl_resepsi    = $this->input->post('tgl_resepsi');
        $jumlah_tamu    = $this->input->post('jumlah_tamu');
        $paket          = $this->input->post('paket');
        $paket_ekstra   = $this->input->post('paket_ekstra');

        $params = array(
				'id_pelanggan' => $id_pelanggan,
				'id_vendor' => $id_vendor,
				'tgl_resepsi' => $tgl_resepsi,
                'jumlah_tamu'=>$jumlah_tamu
            );
            
            $pesanan_id = $this->Pesanan_model->add_pesanan($params);
            if($pesanan_id > 0){
                
                $kode_unik = rand(0,999);
                 $get_harga = $this->Paket_model->get_harga_paket($paket[0]);
                    $sub_pembayaran += $get_harga['harga'];
                    $get_harga_catering = $this->Paket_model->get_harga_paket($paket[1]);
                    $sub_pembayaran_catering += $get_harga_catering['harga'] * $jumlah_tamu;
                for($i = 0; $i < count($paket); $i++){
                    $params_detail_pesanan[$i] = array(
                    'id_pesanan'=>$pesanan_id,
                    'id_paket'=>$paket[$i]
                    );
                };
                if(count($paket_ekstra)>0){
                    for($i = 0; $i < count($paket_ekstra); $i++){
                        $params_detail_pesanan2[$i] = array(
                        'id_pesanan'=>$pesanan_id,
                        'id_paket'=>$paket_ekstra[$i]
                        );
                        $get_harga = $this->Paket_model->get_harga_paket($paket_ekstra[$i]);
                        $sub_pembayaran1 += $get_harga['harga'];
                    };
                $this->Pesanan_detail_model->add_pesanan_detail($params_detail_pesanan2);
                }else{
                    $sub_pembayaran1 = 0;
                }
                $total_pembayaran = $sub_pembayaran + $sub_pembayaran_catering + $sub_pembayaran1;
                
                $params_pembayaran = array(
                    'id_pesanan'=>$pesanan_id,
                    'total_pembayaran'=>$total_pembayaran,
                    'status'=>1
                );
                $this->Pembayaran_model->add_pembayaran($params_pembayaran);
                $this->Pesanan_detail_model->add_pesanan_detail($params_detail_pesanan);
                //echo number_format($total_pembayaran);
                
                $this->session->set_flashdata('notif_input','<p class="text-success">Success Add Pesanan.</p>');
                redirect('');

            }
    }

    public function pesananku(){
        $check_logged_id = $this->ekstra->check_logged_id_pelanggan($this->logged_id);
        if(!$check_logged_id){
            redirect('pelanggan/login');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'pelanggan'){
            show_404();
        }
        $this->load->model('Pelanggan_model');

        $get_pelanggan = $this->Pelanggan_model->get_pelanggan($this->id_user);
        $data['get_mypesanan'] = $this->Pesanan_model->get_all_mypesanan($get_pelanggan['id_pelanggan']);

        $data['_view'] = 'pesanan/pesananku';
        $this->load->view('layouts/main_pelanggan',$data);
    }

    public function detail_mypesanan($id_pesanan){
        $check_logged_id = $this->ekstra->check_logged_id_pelanggan($this->logged_id);
        if(!$check_logged_id){
            redirect('pelanggan/login');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'pelanggan'){
            show_404();
        }
        $this->load->model('Pelanggan_model');
        $this->load->model('Pesanan_detail_model');

        $get_pelanggan = $this->Pelanggan_model->get_pelanggan($this->id_user);
        $data['get_mypesanan'] = $this->Pesanan_model->get_mypesanan($get_pelanggan['id_pelanggan'], $id_pesanan);
        $data['get_mypesanandetail'] = $this->Pesanan_detail_model->get_mypesanan_detail($id_pesanan);

        $data['_view'] = 'pesanan/pesananku_detail';
        $this->load->view('layouts/main_pelanggan',$data);
    }
    
}
