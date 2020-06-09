<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Settings extends Admin_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->load->model('settings_model');
        $this->lang->load('auth');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            redirect('dashboard', 'refresh');
        }
        $this->data['page_title'] = ucwords(lang('settings'));
        $this->data['breadcrumb'] = array(
            'dashboard' => ucwords(lang('dashboard')),
            'settings' => ucwords(lang('settings'))
        );

        $settings = $this->settings_model->get_settings();
        if (isset($_POST) && !empty($_POST)) {
            // validate form input
            $this->form_validation->set_rules('site_name', $this->lang->line('site_name_validation'), 'trim|required');
            $this->form_validation->set_rules('admin_email', $this->lang->line('admin_email_validation'), 'trim|required');
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE) {
                show_error($this->lang->line('error_csrf'));
            }

            if ($this->form_validation->run() === TRUE) {
                $company_logo = 'logo.png';
                if (!empty($_FILES['logo']['name'])) {
                    if ($this->input->post('old_logo') != '' && $this->input->post('old_logo') != 'logo.png' && file_exists(FCPATH . 'assets/img/company/' . $this->input->post('old_logo'))) {
                        unlink(FCPATH . 'assets/img/company/' . $this->input->post('old_logo'));
                    }
                    $company_logo = $this->upload_logo();
                }

                foreach ($settings as $setting) {
                    $data[] = [
                        'key_name' => $setting->key_name,
                        'value'    => ($setting->key_name == 'logo') ? $company_logo : $this->input->post($setting->key_name)
                    ];
                }
                $this->settings_model->update($data);
                $this->session->set_flashdata('success', $this->lang->line('setting_update_success'));
                redirect('settings', 'refresh');
                // if ($this->settings_model->update($data)) {
                //     $this->session->set_flashdata('success', $this->lang->line('setting_update_success'));
                //     redirect('settings', 'refresh');
                // } else {
                //     $this->session->set_flashdata('message', $this->lang->line('setting_update_error'));
                //     redirect('settings', 'refresh');
                // }
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('settings', 'refresh');
            }
        }

        // $settings = $this->settings_model->get_settings();
        // echo "<pre>"; print_r($settings);exit();
        $this->data['settings'] = $settings;
        $this->data['csrf'] = $this->_get_csrf_nonce();
        $this->render('settings', 'admin');
    }

    public function upload_logo()
    {
        $filename = $_FILES['logo']['name'];
        $tmpname = $_FILES['logo']['tmp_name'];
        $exp = explode('.', $filename);
        $ext = end($exp);
        $newname =  $exp[0] . '_' . time() . "." . $ext;
        $config['upload_path'] = 'assets/img/company/';
        $config['upload_url'] =  base_url() . 'assets/img/company/';
        $config['allowed_types'] = "gif|jpg|jpeg|png|iso";
        $config['max_size'] = '2000000';
        $config['file_name'] = $newname;
        $this->load->library('upload', $config);
        move_uploaded_file($tmpname, "assets/img/company/" . $newname);
        return $newname;
    }

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return [$key => $value];
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return TRUE;
        }
        return FALSE;
    }
}
