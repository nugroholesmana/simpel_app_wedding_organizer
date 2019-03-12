<?php
class Format_tanggal{
    public function format1($tanggal){
        $thn = substr($tanggal,0,4);
        $bln = substr($tanggal,5,2);
        $tgl = substr($tanggal,8,2);     

        return $tgl.'/'.$bln.'/'.$thn;  
        //outpout example : 23/02/2017
    }

    public function get_month($tanggal){
        $bln = substr($tanggal,5,2);   
        if($bln == "01"){
        	$bulan = "Januari";
        }elseif($bln == "02"){
        	$bulan = "Febuari";
        }elseif($bln == "03"){
        	$bulan = "Maret";
        }elseif($bln == "04"){
        	$bulan = "April";
        }elseif($bln == "05"){
        	$bulan = "Mei";
        }elseif($bln == "06"){
        	$bulan = "Juni";
        }elseif($bln == "07"){
        	$bulan = "Juli";
        }elseif($bln == "08"){
        	$bulan = "Agustus";
        }elseif($bln == "09"){
        	$bulan = "September";
        }elseif($bln == "10"){
        	$bulan = "Oktober";
        }elseif($bln == "11"){
        	$bulan = "November";
        }elseif($bln == "12"){
        	$bulan = "Desember";
        }

        return $bulan;  
    }
    public function get_month2($tanggal){
        $bln = substr($tanggal,5,2); 
        return $bln;  
    }

    public function get_year($tanggal){
        $thn = substr($tanggal,0,4);    
        return $thn;  
    }
}
?>