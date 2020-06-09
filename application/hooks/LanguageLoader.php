<?php
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
        $siteLang = $ci->session->userdata('site_lang');
        $sitePage = $ci->session->userdata('site_page');
        if ($siteLang && $sitePage) {
            if (file_exists(APPPATH."language/".$siteLang."/".$sitePage."_lang.php")) {
                $ci->lang->load($sitePage, $siteLang);
            }
        }

        if($siteLang){
            if (file_exists(APPPATH."language/".$siteLang."/site_lang.php")) {
                $ci->lang->load('site', $siteLang);
            }
            if (file_exists(APPPATH."language/".$siteLang."/menu_lang.php")) {
                $ci->lang->load('menu', $siteLang);
            }
        }
    }
}