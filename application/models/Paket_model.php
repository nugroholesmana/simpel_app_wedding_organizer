<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Paket_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_paket($id_konten)
    {
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        return $this->db->get_where('tbl_paket',array('id_konten'=>$id_konten))->row_array();
    }
    function get_harga_paket($id_konten)
    {
        $this->db->select('harga');
        return $this->db->get_where('tbl_paket',array('id_konten'=>$id_konten))->row_array();
    }
        
    function get_all_paket()
    {
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        $this->db->order_by('id_konten', 'desc');
        return $this->db->get('tbl_paket')->result_array();
    }
    /**********************PAKET UNTUK ADMIN********************************/
    function get_all_paket_pagination($number, $offset){
        $this->db->order_by('tipe', 'ASC');
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        $this->db->select('id_konten, tipe, tbl_vendor.id_vendor, nama_konten, harga, id_user, nama_vendor');
        return $this->db->get('tbl_paket', $number, $offset)->result_array();
    }

    function search_paket($berdasarkan, $string_value){
        if($berdasarkan == "id_konten"){
            $this->db->where('id_konten', $string_value);
        }elseif($berdasarkan == "id_vendor"){
            $this->db->where('tbl_vendor.id_vendor', $string_value);
        }
        $this->db->order_by('tipe', 'ASC');
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        $this->db->select('id_konten, tipe, tbl_vendor.id_vendor, nama_konten, harga, id_user, nama_vendor');
        return $this->db->get('tbl_paket')->result_array();

    }

    function total_paket(){
        return $this->db->get('tbl_paket')->num_rows();
    }
    /**********************PAKET UNTUK ADMIN WO********************************/
    function get_all_paket_pagination_admin($id_vendor, $number, $offset){
        $this->db->where('tbl_paket.id_vendor',$id_vendor);
        $this->db->order_by('tipe', 'ASC');
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        $this->db->select('id_konten, tipe, tbl_vendor.id_vendor, nama_konten, harga, id_user, nama_vendor');
        return $this->db->get('tbl_paket', $number, $offset)->result_array();
    }

    function search_paket_admin($id_vendor, $berdasarkan, $string_value){
        $this->db->where('tbl_paket.id_vendor',$id_vendor);
        if($berdasarkan == "id_konten"){
            $this->db->where('id_konten', $string_value);
        }elseif($berdasarkan == "id_vendor"){
            $this->db->where('tbl_vendor.id_vendor', $string_value);
        }
        $this->db->order_by('tipe', 'ASC');
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        $this->db->select('id_konten, tipe, tbl_vendor.id_vendor, nama_konten, harga, id_user, nama_vendor');
        return $this->db->get('tbl_paket')->result_array();

    }

    function total_paket_admin($id_vendor){
        $this->db->where('tbl_paket.id_vendor',$id_vendor);
        return $this->db->get('tbl_paket')->num_rows();
    }

    function get_all_paket_pertipe($id_vendor,$tipe)
    {
        $this->db->where('id_vendor', $id_vendor);
        $this->db->where('tipe', $tipe);
        $this->db->order_by('nama_konten', 'ASC');
        return $this->db->get('tbl_paket')->result_array();
    }
    function get_paket_pertipe($id_vendor,$tipe)
    {
        $this->db->where('id_vendor', $id_vendor);
        $this->db->where('tipe', $tipe);
        $this->db->order_by('nama_konten', 'ASC');
        return $this->db->get('tbl_paket')->row_array();
    }
        
    function add_paket($params)
    {
        $this->db->insert('tbl_paket',$params);
        return $this->db->insert_id();
    }
    
    function update_paket($id_konten,$params)
    {
        $this->db->where('id_konten',$id_konten);
        return $this->db->update('tbl_paket',$params);
    }
    
    function delete_paket($id_konten)
    {
        return $this->db->delete('tbl_paket',array('id_konten'=>$id_konten));
    }
    /** PELANGGAN MODEL **/
    function total_paket_pertipe($tipe){
        return $this->db->get_where('tbl_paket', array('tipe'=>$tipe))->num_rows();
    }
    function list_paket_pertipe($tipe, $number, $offset){
        $this->db->where('tbl_paket.tipe',$tipe);
        $this->db->join('tbl_vendor','tbl_paket.id_vendor = tbl_vendor.id_vendor');
        return $this->db->get('tbl_paket', $number, $offset)->result_array();
    }
    function g_paket($id_vendor){
        $this->db->where('tbl_paket.id_vendor',$id_vendor);
        $this->db->order_by('tipe','ASC');
        return $this->db->get('tbl_paket')->result_array();
    }
}
