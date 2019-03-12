<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
class Galeri_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_galeri($id_galeri)
    {
        return $this->db->get_where('tbl_galeri',array('id_galeri'=>$id_galeri))->row_array();
    }
        
    function get_all_galeri()
    {
        $this->db->join('tbl_vendor','tbl_galeri.id_vendor = tbl_vendor.id_vendor');
        $this->db->order_by('id_galeri', 'desc');
        return $this->db->get('tbl_galeri')->result_array();
    }
    
    /*****************ADMIN MODEL*********************/
    function get_all_galeri_pagination($number, $offset){
        $this->db->join('tbl_vendor','tbl_galeri.id_vendor = tbl_vendor.id_vendor');
        $this->db->select('tbl_galeri.id_vendor, gambar, id_galeri, nama_vendor');
        $this->db->order_by('id_galeri', 'desc');
        return $this->db->get('tbl_galeri',$number,$offset)->result_array();
    }
    function search_galeri($berdasarkan, $string_value){
        if($berdasarkan == "nama_vendor"){
            $this->db->like('tbl_vendor.nama_vendor', $string_value);
        }
        $this->db->select('tbl_galeri.id_vendor, gambar, id_galeri, nama_vendor');
        $this->db->join('tbl_vendor','tbl_galeri.id_vendor = tbl_vendor.id_vendor');
        $this->db->order_by('id_galeri', 'desc');
        return $this->db->get('tbl_galeri')->result_array();

    }
    function total_galeri(){
        return $this->db->get('tbl_galeri')->num_rows();
    }
    /*****************ADMIN WO MODEL*********************/
    function get_all_galeri_pagination_admin($id_vendor, $number, $offset){
        $this->db->where('tbl_galeri.id_vendor',$id_vendor);
        $this->db->join('tbl_vendor','tbl_galeri.id_vendor = tbl_vendor.id_vendor');
        $this->db->select('tbl_galeri.id_vendor, gambar, id_galeri, nama_vendor');
        $this->db->order_by('id_galeri', 'desc');
        return $this->db->get('tbl_galeri',$number,$offset)->result_array();
    }
    function total_galeri_admin($id_vendor){
        $this->db->where('tbl_galeri.id_vendor',$id_vendor);
        return $this->db->get('tbl_galeri')->num_rows();
    }

    function add_galeri($params)
    {
        $this->db->insert('tbl_galeri',$params);
        return $this->db->insert_id();
    }
    
    function update_galeri($id_galeri,$params)
    {
        $this->db->where('id_galeri',$id_galeri);
        return $this->db->update('tbl_galeri',$params);
    }
    
    function delete_galeri($id_galeri)
    {
        return $this->db->delete('tbl_galeri',array('id_galeri'=>$id_galeri));
    }
    /** PELANGGAN **/
}
