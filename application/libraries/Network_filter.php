<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Network_filter{

	public function anti_injection($stringInput){
		return strip_tags($stringInput);
	}
}
?>