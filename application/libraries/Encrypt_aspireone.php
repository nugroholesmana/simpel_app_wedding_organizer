<?php 
/* 
 * Author : Nugroho Lesmana
 * Year : 2017
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');
define ('AES_256_CBC', 'aes-256-cbc');
class Encrypt_aspireone {
    // Generate a 256-bit encryption key
    // This should be stored somewhere instead of recreating it each time
    var $skey   = "frhejfk0j21hdncj9384ba219";
    // Generate an initialization vector
    // This *MUST* be available for decryption as well
    var $sIV    = "a857iproject30kx";
    
    public function encode($string) {    
        // Encrypt $data using aes-256-cbc cipher with the given encryption key and 
        // our initialization vector. The 0 gives us the default options, but can
        // be changed to OPENSSL_RAW_DATA or OPENSSL_ZERO_PADDING
        $string = $string."#".time();
        $encryption = openssl_encrypt($string, AES_256_CBC, $this->skey, 0, $this->sIV);
        return $encryption;
    }
 
    public function decode($string) {
        $decryption = $string;
        $decryption = openssl_decrypt($string, AES_256_CBC, $this->skey, 0, $this->sIV);
        $decryption = explode('#',$decryption);
        return $decryption[0];
    }

    public function passwordHash($password){
        $options = ['cost'=>10];
        return password_hash($password,PASSWORD_BCRYPT,$options);
    }
    public function passwordVerify($password, $hash){
        return password_verify($password, $hash);
    }
}
?>