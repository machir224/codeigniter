<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $data = array();

	function __construct()
	{
        parent::__construct();
        $this->load->library(array('ion_auth', 'encrypt', 'ssp'));
        $this->data['page_title'] = '';
        $this->data['before_head'] = '';
        $this->data['before_body'] = '';
        $siteLang = $this->session->userdata('site_lang');
        if(!$siteLang){
        	$default_lang = 'english';
        	if($this->config->item('language')){
        		$default_lang = $this->config->item('language');
        	}
        	$this->session->set_userdata('site_lang', $default_lang);
        }
        $this->load->model('settings/settings_model');
        $settings = $this->settings_model->get_settings();
        $site_settings = [];
        foreach ($settings as $setting) {
            $site_settings[$setting->key_name] = $setting->value;
        }
        $this->data['site_settings'] = $site_settings;
	}

	protected function render($the_view = NULL, $template = '')
	{
        if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		elseif(is_null($template))
		{
			$this->load->view($the_view, $this->data);
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
    }
    
    protected function myEncrypt($data = ''){
        $encrypted = '';
        if($data != '') {
            // $encrypted = base64_encode($this->encrypt->encode((string)$data));
            $encrypted = $this->encrypt->encode($data);
        }
        return $encrypted;
    }

    protected function myDecrypt($data = ''){
        $decrypted = '';
        if($data != '') {
            // $decrypted = $this->encrypt->decode(base64_decode((string)$data));
            $decrypted = $this->encrypt->decode($data);
        }
        return $decrypted;
    }
}

class Admin_Controller extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->ion_auth->logged_in()){
            redirect('user/login', 'refresh');
        }
	}
	protected function render($the_view = NULL, $template = 'admin')
	{
		parent::render($the_view, $template);
	}
}

class Public_Controller extends MY_Controller
{
    function __construct()
	{
        parent::__construct();
	}

    protected function render($the_view = NULL, $template = 'public')
    {
        parent::render($the_view, $template);
    }
}
