<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends Public_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
    public function index()
    {
        $this->data['page_title'] = ucwords(lang('home'));
        $this->data['breadcrumb'] = array(
                                            '' => ucwords(lang('home')),
                                        );
    	$this->data['result'] = "Hello<br/>This is Home page content<br/>".lang('welcome_message');
        $this->session->set_userdata('site_page', 'home');
        $this->render('home');
    }

    public function contact_us()
    {
    	$this->data['page_title'] = ucwords(lang('contact_us'));
    	$this->data['breadcrumb'] = array(
    										'' => ucwords(lang('home')),
    										'contact_us' => ucwords(lang('contact_us'))
    									);
    	$this->data['result'] = "Hello<br/>This is Contact page content";
        $this->render('contact_us');
    }

    public function about_us()
    {
    	$this->data['page_title'] = ucwords(lang('about_us'));
    	$this->data['breadcrumb'] = array(
    										'' => ucwords(lang('home')),
    										'about_us' => ucwords(lang('about_us'))
    									);
    	$this->data['result'] = "Hello<br/>This is About page content";
        $this->render('about_us');
    }
}
