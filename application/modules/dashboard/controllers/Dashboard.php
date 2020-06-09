<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Dashboard extends Admin_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('user/login', 'refresh');
        }
        $this->data['page_title'] = ucwords(lang('dashboard'));
        $this->data['breadcrumb'] = array(
            'user' => ucwords(lang('dashboard'))
        );
        $this->data['users'] = $this->ion_auth->users(2)->result();
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }
        // echo "<pre>"; print_r($this);exit();
        $this->render('dashboard', 'admin');
    }
}
