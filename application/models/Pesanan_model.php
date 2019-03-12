<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Pesanan_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_pesanan($id_pesanan)
    {
        $this->db->join('tbl_pembayaran', 'tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->join('tbl_vendor', 'tbl_datapesanan.id_vendor = tbl_vendor.id_vendor');
        $this->db->join('tbl_datapelanggan', 'tbl_datapesanan.id_pelanggan = tbl_datapelanggan.id_pelanggan');
        return $this->db->get_where('tbl_datapesanan',array('tbl_datapesanan.id_pesanan'=>$id_pesanan))->row_array();
    }
        
    function get_all_pesanan()
    {
        $this->db->select('tbl_datapesanan.id_pesanan, id_pelanggan, total_pembayaran, tgl_resepsi, status');
        $this->db->join('tbl_pembayaran', 'tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->order_by('id_pesanan', 'desc');
        return $this->db->get('tbl_datapesanan')->result_array();
    }

    function get_all_mypesanan($id_pelanggan)
    {
        $this->db->where('tbl_datapesanan.id_pelanggan',$id_pelanggan);
        $this->db->select('tbl_datapesanan.id_pesanan, tbl_datapesanan.id_vendor, nama_vendor,  id_pelanggan, total_pembayaran, tgl_resepsi, status');
        $this->db->join('tbl_pembayaran', 'tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->join('tbl_vendor', 'tbl_datapesanan.id_vendor = tbl_vendor.id_vendor');
        $this->db->order_by('id_pesanan', 'desc');
        return $this->db->get('tbl_datapesanan')->result_array();
    }
    function get_mypesanan($id_pelanggan,$id_pesanan)
    {
        $this->db->where('tbl_datapesanan.id_pelanggan',$id_pelanggan);
        $this->db->where('tbl_datapesanan.id_pesanan',$id_pesanan);
        $this->db->select('tbl_datapesanan.id_pesanan, tbl_datapesanan.id_vendor, nama_vendor, id_pelanggan, total_pembayaran, tgl_resepsi, status, jumlah_tamu, no_telp_vendor, tbl_vendor.alamat');
        $this->db->join('tbl_pembayaran', 'tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->join('tbl_vendor', 'tbl_datapesanan.id_vendor = tbl_vendor.id_vendor');
        $this->db->order_by('id_pesanan', 'desc');
        return $this->db->get('tbl_datapesanan')->row_array();
    }

    function get_all_pesanan_pagination($number, $offset){
        $this->db->order_by('nama_pelanggan', 'ASC');
        $this->db->order_by('id_pesanan', 'desc');
        $this->db->order_by('status', 'asc');
        $this->db->join('tbl_datapelanggan','tbl_datapesanan.id_pelanggan = tbl_datapelanggan.id_pelanggan');
        $this->db->join('tbl_pembayaran','tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->select('tbl_datapesanan.id_pesanan, tbl_datapesanan.id_pelanggan, total_pembayaran, tgl_resepsi, status');
        return $this->db->get('tbl_datapesanan',$number,$offset)->result_array();
    }

    function search_pesanan($berdasarkan, $string_value){
        if($berdasarkan == "id_pelanggan"){
            $this->db->where('tbl_datapesanan.id_pelanggan', $string_value);
        }elseif($berdasarkan == "id_pesanan"){
            $this->db->where('tbl_datapesanan.id_pesanan', $string_value);
        }
        $this->db->order_by('nama_pelanggan', 'ASC');
        $this->db->order_by('tbl_datapesanan.id_pesanan', 'desc');
        $this->db->order_by('status', 'asc');
        $this->db->join('tbl_datapelanggan','tbl_datapesanan.id_pelanggan = tbl_datapelanggan.id_pelanggan');
        $this->db->join('tbl_pembayaran','tbl_datapesanan.id_pesanan = tbl_pembayaran.id_pesanan');
        $this->db->select('tbl_datapesanan.id_pesanan, tbl_datapesanan.id_pelanggan, total_pembayaran, tgl_resepsi, status');
        return $this->db->get('tbl_datapesanan')->result_array();

    }

    function total_pesanan(){
        return $this->db->get('tbl_datapesanan')->num_rows();
    }
       
    function add_pesanan($params)
    {
        $this->db->insert('tbl_datapesanan',$params);
        return $this->db->insert_id();
    }
    
    function update_pesanan($id_pesanan,$params)
    {
        $this->db->where('id_pesanan',$id_pesanan);
        return $this->db->update('tbl_datapesanan',$params);
    }
    
    function delete_pesanan($id_pesanan)
    {
        return $this->db->delete('tbl_datapesanan',array('id_pesanan'=>$id_pesanan));
    }
}
