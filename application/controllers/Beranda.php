<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('Paket_model');
    }   

    public function index($tipe = 1)
    {
        $jumlah_paket = $this->Paket_model->total_paket_pertipe($tipe);
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
            $config['base_url'] = base_url().'beranda/index/';
            $config['total_rows'] = $jumlah_paket;
            $config['per_page'] = 15;
            $from = $this->uri->segment(4);
            $this->pagination->initialize($config);
            $data['paket'] = $this->Paket_model->list_paket_pertipe($tipe, $config['per_page'],$from);
            $data['offset'] = $from;
        echo $from;
        
        $data['_view'] = 'paket/listing_paket_pertipe';
        $this->load->view('layouts/main_pelanggan',$data);
    }

}

