<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Vendor_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_vendor($id_user)
    {
        $this->db->join('tbl_datauser','tbl_vendor.id_user = tbl_datauser.id_user');
        return $this->db->get_where('tbl_vendor',array('tbl_vendor.id_user'=>$id_user))->row_array();
    }
    function get_vendor_2($id_vendor)
    {
        return $this->db->get_where('tbl_vendor',array('id_vendor'=>$id_vendor))->row_array();
    }
        
    function get_all_vendor()
    {
        $this->db->order_by('nama_vendor','ASC');
        $this->db->join('tbl_datauser','tbl_vendor.id_user = tbl_datauser.id_user');
        $this->db->order_by('id_vendor', 'desc');
        return $this->db->get('tbl_vendor')->result_array();
    }

    function get_all_vendor_pagination($number, $offset){
        $this->db->order_by('nama_vendor', 'ASC');
        $this->db->join('tbl_datauser', 'tbl_vendor.id_user = tbl_datauser.id_user');
        $this->db->select('nama_vendor, tbl_vendor.id_user, id_vendor, nama_pemilik_vendor, email, no_telp_vendor');
        return $this->db->get('tbl_vendor',$number,$offset)->result_array();
    }

    function search_vendor($berdasarkan, $string_value){
        if($berdasarkan == "id_vendor"){
            $this->db->where('id_vendor', $string_value);
        }elseif($berdasarkan == "email"){
            $this->db->where('email', $string_value);
        }elseif($berdasarkan == "nama_vendor"){
            $this->db->where('nama_vendor', $string_value);
        }
        $this->db->join('tbl_datauser', 'tbl_vendor.id_user = tbl_datauser.id_user');
        $this->db->select('nama_vendor, tbl_vendor.id_user, id_vendor, nama_pemilik_vendor, email, no_telp_vendor');
        return $this->db->get('tbl_vendor')->result_array();

    }

    function total_vendor(){
        return $this->db->get('tbl_vendor')->num_rows();
    }
        
    function add_vendor($params)
    {
        $this->db->insert('tbl_vendor',$params);
        return $this->db->insert_id();
    }
    
    function update_vendor($id_vendor,$params)
    {
        $this->db->where('id_vendor',$id_vendor);
        return $this->db->update('tbl_vendor',$params);
    }
    
    function delete_vendor($id_user)
    {
        return $this->db->delete('tbl_vendor',array('id_user'=>$id_user));
    }
}
