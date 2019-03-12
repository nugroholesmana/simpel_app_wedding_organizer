<?php
class Ekstra{

    public $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }
    
    /***************Convert text hak akses******************/
    public function hak_akses($string){
        if($string == "admin"){
            return "Admin";
        }elseif($string == "admin_wo"){
            return "Admin WO";
        }elseif($string == "pelanggan"){
            return "Pelanggan";
        }
    }
    public function status_user($string){
        if($string == "1"){
            return "Aktif";
        }elseif($string == "2"){
            return "Tidak Aktif";
        }
    }
    public function status_pembayaran($string){
        if($string == "1"){
            return '<span class="text-info">Menunggu Pembayaran</span>';
        }elseif($string == "2"){
            return '<span class="text-success">Pembayaran Diterima</span>';
        }elseif($string == "3"){
            return '<span class="text-danger">Pembatalan Pembayaran</span>';
        }
    }
    public function tipe_paket($string){
        if($string == "1"){
            return "Paket Utama";
        }elseif($string == "2"){
            return "Catering";
        }elseif($string == "3"){
            return "Ekstra";
        }
    }

    public function check_logged_id($string){   
        $this->ci->config->load('globals_var');
        $key_logged_id = $this->ci->config->item('key_logged_id');       
        if($string == $key_logged_id){            
            return true;            
        }else{
            return false;
        }      
    }
    public function check_logged_id_pelanggan($string){   
        $this->ci->config->load('globals_var');
        $key_logged_id = $this->ci->config->item('key_logged_id_pelanggan');       
        if($string == $key_logged_id){            
            return true;            
        }else{
            return false;
        }      
    }
}
?>