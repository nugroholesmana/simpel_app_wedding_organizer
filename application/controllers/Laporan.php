<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public $id_user;
    public $logged_id;
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->library('Encrypt_aspireone');
        $this->load->library('Ekstra');
        $this->load->library('M_pdf');

        $this->id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        $this->logged_id = $this->encrypt_aspireone->decode($this->session->userdata('logged_id'));
    }
    
    public function laporan_user()
    {
        $this->load->model('User_model');
        $data['user'] = $this->User_model->get_all_user();
        //convert to PDF
        $html = $this->load->view('laporan/laporan_user',$data, true);
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        //this the the PDF filename that user will get to download
        $pdfFilePath = "laporan-user-".date('dmY').".pdf";

        //load mPDF library

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output();
    }

    public function laporan_Pelanggan()
    {
        $this->load->model('Pelanggan_model');
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['total_pelanggan'] = $this->Pelanggan_model->total_pelanggan();
        //convert to PDF
        $html = $this->load->view('laporan/laporan_pelanggan',$data, true);
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        //this the the PDF filename that user will get to download
        $pdfFilePath = "laporan-pelanggan-".date('dmY').".pdf";

        //load mPDF library

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output();
    }

    public function laporan_Vendor()
    {
        $this->load->model('Vendor_model');
        $data['vendor'] = $this->Vendor_model->get_all_vendor();
        $data['total_vendor'] = $this->Vendor_model->total_vendor();
        //convert to PDF
        $html = $this->load->view('laporan/laporan_vendor',$data, true);
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        //this the the PDF filename that user will get to download
        $pdfFilePath = "laporan-vendor-".date('dmY').".pdf";

        //load mPDF library

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output();
    }

    public function laporan_pesanan()
    {        
        $check_logged_id = $this->ekstra->check_logged_id($this->logged_id);
        if($check_logged_id == false){
            redirect('login/wo_admin');
        }
        $data['get_user'] = $this->User_model->get_user($this->id_user);
        if($data['get_user']['hak_akses'] != 'admin'){
            show_404();
        }

        $data['_view'] = 'laporan/laporan_pesanan';
        $this->load->view('layouts/main',$data);
    }
    public function print_laporan_pesanan()
    {
        $this->load->model('Laporan_model'); 

        $berdasarkan = $this->input->post('berdasarkan');
        $string_value = $this->input->post('string_value');
        $string_combo = $this->input->post('string_combo');
        $string_value1 = $this->input->post('string_value1');
        $string_value2 = $this->input->post('string_value2');

        $explode_tgl_1 = explode('/',$string_value1);
        $explode_tgl_2 = explode('/',$string_value2);
        $string_value1 = $explode_tgl_1[2].'-'.$explode_tgl_1[1].'-'.$explode_tgl_1[0];
        $string_value2 = $explode_tgl_2[2].'-'.$explode_tgl_2[1].'-'.$explode_tgl_2[0];
        $data['pesanan'] = $this->Laporan_model->laporan_pesanan($berdasarkan, $string_value, $string_combo, $string_value1, $string_value2);
        $data['get_pesanan'] = $this->Laporan_model->get_laporan_pesanan($berdasarkan, $string_value, $string_combo, $string_value1, $string_value2);
        //$this->load->view('laporan/print_laporan_pesanan',$data);

        //convert to PDF
        $html = $this->load->view('laporan/print_laporan_pesanan',$data, true);
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        //this the the PDF filename that user will get to download
        $pdfFilePath = "laporan-pesanan-".date('dmY').".pdf";

        //load mPDF library

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output();
    }

    public function nota_pembayaran()
    {
        $this->load->library('Encrypt_aspireone');
        $id_user = $this->encrypt_aspireone->decode($this->session->userdata('id_user'));
        
        $id_pesanan = $this->encrypt_aspireone->decode($this->input->get('q'));

        $this->load->model('Laporan_model');
        $this->load->model('User_model');

        $data['check_user'] = $this->User_model->check_user(array('id_user'=>$id_user));

        $data['pesanan'] = $this->Laporan_model->get_nota_pembayaran($id_pesanan);
        $data['pesanan_paket'] = $this->Laporan_model->get_paket_nota_pembayaran($id_pesanan);
        $data['pesanan_paket_catering'] = $this->Laporan_model->get_paket_nota_pembayaran_catering($id_pesanan);
        $data['id_user'] = $id_user;
        //convert to PDF
        $html = $this->load->view('laporan/nota_pembayaran',$data, true);
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        //this the the PDF filename that user will get to download
        $pdfFilePath = "laporan-user-".date('dmY').".pdf";

        //load mPDF library

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output();
    }

}

