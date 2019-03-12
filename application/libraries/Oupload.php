<?php
class Oupload{

	public $directory_file;
	public $max_file;


	//set direktori file
	function setDirectory($direktori){
		$this->directory_file = $direktori;
	}

	//set ukuran kapasitas file
	function setMaksFile($ukuran){
		$this->max_file = $ukuran;
	}

	public function proses_upload($nama_file,$nama_baru){
		$this->ci 	= &get_instance();
		//Variabelnya
		@$namaFile 		= $_FILES[$nama_file]['name'];
		@$tmpFile		= $_FILES[$nama_file]['tmp_name'];
		@$sizeFile 		= $_FILES[$nama_file]['size'];
		@$maxSizeFile 	= 1024 * $this->max_file;

		//cek format di izinkan
		$formatFile	= array('jpg','png','gif');
		//ambil format file
		$pecah		= explode('.', $namaFile);
		$ekstensi	= $pecah[count($pecah)-1];

		$namaBaru 	= $nama_baru.'.'.$ekstensi;
		//cek ukuran file
		
		if($sizeFile > $maxSizeFile){
			$this->ci->session->set_flashdata('notif_input', "<p class='red-text'>Ukuran file tidak boleh lebih dari $this->max_file KB</p>");
			$error = false;
		}

		//cek dulu filenya di inputkan atau tidak
		if($namaFile){
			if(!in_array($ekstensi, $formatFile)){
				return $this->ci->session->set_flashdata('notif_input', "<p class='red-text'>Format Tidak dizinkan</p>");
				$error = false;
			}	
		}else{
			return true;
		}
		

		if(!$error){
			return move_uploaded_file($tmpFile, $this->directory_file.$namaBaru);
		}

	}
}