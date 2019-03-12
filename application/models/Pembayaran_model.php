<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class Pembayaran_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_tbl_pembayaran($id_pembayaran)
    {
        return $this->db->get_where('tbl_pembayaran',array('id_pembayaran'=>$id_pembayaran))->row_array();
    }

    function get_all_tbl_pembayaran()
    {
        $this->db->order_by('id_pembayaran', 'desc');
        return $this->db->get('tbl_pembayaran')->result_array();
    }

    function add_pembayaran($params)
    {
        $this->db->insert('tbl_pembayaran',$params);
        return $this->db->insert_id();
    }
    
    function update_pembayaran($id_pesanan,$params)
    {
        $this->db->where('id_pesanan',$id_pesanan);
        return $this->db->update('tbl_pembayaran',$params);
    }
    
    function delete_tbl_pembayaran($id_pembayaran)
    {
        return $this->db->delete('tbl_pembayaran',array('id_pembayaran'=>$id_pembayaran));
    }
}
