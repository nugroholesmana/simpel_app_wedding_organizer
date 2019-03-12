<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Pelanggan_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_pelanggan($id_user)
    {
        return $this->db->get_where('tbl_datapelanggan',array('id_user'=>$id_user))->row_array();
    }
    function get_pelanggan_2($id_pelanggan)
    {
        return $this->db->get_where('tbl_datapelanggan',array('id_pelanggan'=>$id_pelanggan))->row_array();
    }

    function get_pelanggan_3($id_user){
        $this->db->join('tbl_datauser','tbl_datapelanggan.id_user = tbl_datauser.id_user');
        return $this->db->get_where('tbl_datapelanggan',array('tbl_datauser.id_user'=>$id_user))->row_array();
    }
        
    function get_all_pelanggan()
    {
        $this->db->join('tbl_datauser','tbl_datapelanggan.id_user = tbl_datauser.id_user');
        $this->db->order_by('id_pelanggan', 'desc');
        return $this->db->get('tbl_datapelanggan')->result_array();
    }

    function get_all_pelanggan_pagination($number, $offset){
        $this->db->order_by('nama_pelanggan', 'ASC');
        $this->db->join('tbl_datauser','tbl_datapelanggan.id_user = tbl_datauser.id_user');
        $this->db->select('nama_pelanggan, id_pelanggan, tbl_datapelanggan.id_user, email, no_telpon, aktif');
        return $this->db->get('tbl_datapelanggan',$number,$offset)->result_array();
    }

    function search_pelanggan($berdasarkan, $string_value){
        if($berdasarkan == "id_pelanggan"){
            $this->db->where('id_pelanggan', $string_value);
        }elseif($berdasarkan == "email"){
            $this->db->where('email', $string_value);
        }elseif($berdasarkan == "nama_pelanggan"){
            $this->db->where('nama_pelanggan', $string_value);
        }
        $this->db->join('tbl_datauser','tbl_datapelanggan.id_user = tbl_datauser.id_user');
        $this->db->select('nama_pelanggan, id_pelanggan, tbl_datapelanggan.id_user, email, no_telpon, aktif');
        return $this->db->get('tbl_datapelanggan')->result_array();

    }

    function total_pelanggan(){
        return $this->db->get('tbl_datapelanggan')->num_rows();
    }
        
    function add_pelanggan($params)
    {
        $this->db->insert('tbl_datapelanggan',$params);
        return $this->db->insert_id();
    }

    function update_pelanggan($id_user,$params)
    {
        $this->db->where('id_user',$id_user);
        return $this->db->update('tbl_datapelanggan',$params);
    }

    
    function delete_pelanggan($id_user)
    {
        return $this->db->delete('tbl_datapelanggan',array('id_user'=>$id_user));
    }
}
