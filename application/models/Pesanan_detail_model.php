<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
class Pesanan_detail_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }

    function get_pesanan_detail($id_pesanan, $tipe){
        $this->db->where('id_pesanan',$id_pesanan);
        $this->db->where('tipe', $tipe);
        $this->db->join('tbl_paket','tbl_datapesananpaket.id_paket = tbl_paket.id_konten');
        return $this->db->get('tbl_datapesananpaket')->row_array();
    }

    function get_pesanan_detail_2($id_pesanan, $id_konten){
        $this->db->where('id_pesanan',$id_pesanan);
        $this->db->where('id_konten',$id_konten);
        $this->db->join('tbl_paket','tbl_datapesananpaket.id_paket = tbl_paket.id_konten');
        return $this->db->get('tbl_datapesananpaket')->row_array();
    }

    function get_mypesanan_detail($id_pesanan){
        $this->db->where('tbl_datapesanan.id_pesanan',$id_pesanan);
        $this->db->join('tbl_paket','tbl_datapesananpaket.id_paket = tbl_paket.id_konten');
        $this->db->join('tbl_datapesanan','tbl_datapesananpaket.id_pesanan = tbl_datapesanan.id_pesanan');
        return $this->db->get('tbl_datapesananpaket')->result_array();
    }

    function get_all_pesanan_detail($id_pesanan)
    {
        $this->db->join('tbl_paket','tbl_datapesananpaket.id_paket = tbl_paket.id_konten');
        return $this->db->get_where('tbl_datapesananpaket',array('id_pesanan'=>$id_pesanan))->result_array();
    }

    function add_pesanan_detail($params){
        $this->db->insert_batch('tbl_datapesananpaket',$params);
        return $this->db->insert_id();
    }
    function update_pesanan_detail($params)
    {
        return $this->db->update_batch('tbl_datapesananpaket',$params,'id_konten');
    }
    function delete_pesanan_detail($id_pesanan)
    {
        return $this->db->delete('tbl_datapesananpaket',array('id_pesanan'=>$id_pesanan));
    }
}
