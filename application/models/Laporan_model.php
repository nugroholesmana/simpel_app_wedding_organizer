<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }    

    function laporan_pesanan($berdasarkan, $string_value, $string_combo, $string_value1, $string_value2){
        if($berdasarkan == "tgl_resepsi"){
            $this->db->where('tgl_resepsi >=', $string_value1);
            $this->db->where('tgl_resepsi <=', $string_value2);
        }elseif($berdasarkan == "status"){
            $this->db->where('status', $string_combo);
        }elseif($berdasarkan == "id_vendor"){
            $this->db->where('tbl_datapesanan.id_vendor', $string_value);
        }
        $this->db->join('tbl_vendor','tbl_datapesanan.id_vendor = tbl_vendor.id_vendor');
        $this->db->join('tbl_pembayaran','tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        return $this->db->get('tbl_datapesanan')->result_array();
    }

    function get_laporan_pesanan($berdasarkan, $string_value, $string_combo, $string_value1, $string_value2){
        if($berdasarkan == "tgl_resepsi"){
            $this->db->where('tgl_resepsi >=', $string_value1);
            $this->db->where('tgl_resepsi <=', $string_value2);
        }elseif($berdasarkan == "status"){
            $this->db->where('status', $string_combo);
        }elseif($berdasarkan == "id_vendor"){
            $this->db->where('tbl_datapesanan.id_vendor', $string_value);
        }
        $this->db->select_max('total_pembayaran','max_pembayaran');
        $this->db->select_min('total_pembayaran','min_pembayaran');
        $this->db->join('tbl_pembayaran','tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        return $this->db->get('tbl_datapesanan')->row_array();
    }

    public function get_nota_pembayaran($id_pesanan)
    {
        $this->db->where('tbl_datapesanan.id_pesanan', $id_pesanan);
        $this->db->join('tbl_pembayaran','tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->join('tbl_vendor','tbl_datapesanan.id_vendor = tbl_vendor.id_vendor');
        $this->db->join('tbl_datapelanggan','tbl_datapesanan.id_pelanggan = tbl_datapelanggan.id_pelanggan');
        return $this->db->get('tbl_datapesanan')->row_array();
    }

    public function get_paket_nota_pembayaran($id_pesanan)
    {       
        $this->load->library('Ekstra');
        $this->db->order_by('tipe','asc');
        $this->db->order_by('nama_konten','asc');
        $this->db->join('tbl_paket','tbl_datapesananpaket.id_paket = tbl_paket.id_konten');
        return $this->db->get_where('tbl_datapesananpaket',array('id_pesanan'=>$id_pesanan, 'tbl_paket.tipe !='=> '2'))->result_array();
    }
    public function get_paket_nota_pembayaran_catering($id_pesanan)
    {       
        $this->load->library('Ekstra');
        $this->db->order_by('tipe','asc');
        $this->db->order_by('nama_konten','asc');
        $this->db->join('tbl_paket','tbl_datapesananpaket.id_paket = tbl_paket.id_konten');
        return $this->db->get_where('tbl_datapesananpaket',array('id_pesanan'=>$id_pesanan, 'tbl_paket.tipe ='=> '2'))->row_array();
    }

}
