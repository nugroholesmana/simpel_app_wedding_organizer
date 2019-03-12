<?php
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_user($id_user)
    {
        return $this->db->get_where('tbl_datauser',array('id_user'=>$id_user))->row_array();
    }

    function check_user($params){
        return $this->db->get_where('tbl_datauser',$params)->row_array();
    }
        
    function get_all_user()
    {
        $this->db->order_by('id_user', 'desc');
        return $this->db->get('tbl_datauser')->result_array();
    }

    function get_all_user_pagination($number, $offset){
        $this->db->order_by('username', 'ASC');
        $this->db->select('username, id_user, email, hak_akses, aktif');
        return $this->db->get('tbl_datauser',$number,$offset)->result_array();
    }

    function search_user($berdasarkan, $string_value){
        if($berdasarkan == "id_user"){
            $this->db->where('id_user', $string_value);
        }elseif($berdasarkan == "email"){
            $this->db->where('email', $string_value);
        }elseif($berdasarkan == "username"){
            $this->db->where('username', $string_value);
        }
        return $this->db->get('tbl_datauser')->result_array();

    }

    function total_user(){
        return $this->db->get('tbl_datauser')->num_rows();
    }
        
    function add_user($params)
    {
        $this->db->insert('tbl_datauser',$params);
        return $this->db->insert_id();
    }
    
    function update_user($id_user,$params)
    {
        $this->db->where('id_user',$id_user);
        return $this->db->update('tbl_datauser',$params);
    }
    
    function delete_user($id_user)
    {
        return $this->db->delete('tbl_datauser',array('id_user'=>$id_user));
    }
}
