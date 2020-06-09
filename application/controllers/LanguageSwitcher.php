<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LanguageSwitcher extends CI_Controller
{
    public function __construct() {
        parent::__construct();     
    }
 
    function switchLang($language = "") {
    	$default_lang = 'english';
    	
    	if($this->config->item('language') != ''){
    		$default_lang = $this->config->item('language');
    	}
        $language = ($language != "") ? $language : $default_lang;
        $this->session->set_userdata('site_lang', $language);
        
        redirect($_SERVER['HTTP_REFERER']);
        
    }
}