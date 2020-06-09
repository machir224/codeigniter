<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class User extends MY_Controller
{
    public $data = [];
    private $user_group_id = 2;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('user/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('dashboard', 'refresh');
        }

        $this->data['page_title'] = ucwords(lang('users'));
        $this->data['breadcrumb'] = array(
            'dashboard' => ucwords(lang('dashboard')),
            'user' => ucwords(lang('users'))
        );
        // $this->data['users'] = $this->ion_auth->users($this->user_group_id)->result();
        // foreach ($this->data['users'] as $k => $user) {
        //     $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        // }
        $this->render('users', 'admin');
    }

    public function login()
    {
        if ($this->ion_auth->logged_in()) {
            redirect('dashboard', 'refresh');
        }
        $this->data['page_title'] = ucwords(lang('login'));
        $this->data['breadcrumb'] = array(
            '' => ucwords(lang('home')),
            'user/login' => ucwords(lang('login'))
        );

        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === TRUE) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect('dashboard', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('user/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        $this->render('user/login', 'public');
    }

    public function register()
    {
        if (isset($this->data['site_settings']) && $this->data['site_settings']['registration_allowed'] == 0) {
            redirect('user/login', 'refresh');
        }
        if ($this->ion_auth->logged_in()) {
            redirect('dashboard', 'refresh');
        }
        $this->data['page_title'] = ucwords(lang('register'));
        $this->data['breadcrumb'] = array(
            '' => ucwords(lang('home')),
            'user/register' => ucwords(lang('register'))
        );

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            ];

            if ($this->form_validation->run() === TRUE && $insert_id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {
                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect("user/register", 'refresh');
            } else {
                // set the flash data error message if there is one
                $this->session->set_flashdata('message', validation_errors());
            }
        } else {
            $this->session->set_flashdata('message', validation_errors());
        }
        $this->render('user/register', 'public');
    }

    /**
     * Log the user out
     */
    public function logout()
    {
        // log the user out
        $this->ion_auth->logout();
        redirect('user/login', 'refresh');
    }

    // public function get_users()
    // {
    //     if (!$this->ion_auth->logged_in()) {
    //         redirect('user/login', 'refresh');
    //     }
    //     $this->data['page_title'] = ucwords(lang('users'));
    //     $this->data['breadcrumb'] = array(
    //         'dashboard' => ucwords(lang('dashboard')),
    //         'user' => ucwords(lang('users')),
    //         'user/get_users' => ucwords(lang('users'))
    //     );
    //     $this->data['users'] = $this->ion_auth->users($this->user_group_id)->result();
    //     foreach ($this->data['users'] as $k => $user) {
    //         $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
    //     }
    //     // echo "<pre>"; print_r($this->data['users']); exit();
    //     $this->render('users', 'admin');
    // }

    // ajaxcall
    public function get_users()
    {
        // $table = 'users';
        $table = "(select u.*, g.group_id from users u left join users_groups g on u.id = g.user_id where g.group_id = $this->user_group_id) user";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'first_name', 'dt' => 1),
            array('db' => 'last_name', 'dt' => 2),
            array('db' => 'email', 'dt' => 3),
            array('db' => 'active', 'dt' => 4),
            array('db' => 'id', 'dt' => 5),
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        $where = array();
        $output_arr = SSP::custom_complex($_GET, $sql_details, $table, $primaryKey, $columns, $where);
        $count = 1;
        foreach ($output_arr['data'] as $key => $user) {
            $output_arr['data'][$key][0] = $count++;
            $u_id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $u_email = $output_arr['data'][$key][count($output_arr['data'][$key]) - 3];
            $u_status = $output_arr['data'][$key][count($output_arr['data'][$key]) - 2];
            $status_html = ($u_status) ? '<button type="button" class="btn btn-success deactivate_user" data-user-id ="' . $u_id . '" data-user-email ="' . $u_email . '" data-toggle="modal" data-target="#deactivateUserModal">' . lang('index_active_link') . '</button>' : anchor("user/activate/" . $u_id, lang('index_inactive_link'), "class='btn btn-warning'");
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 2] = $status_html;
            $action_html = anchor("user/edit_user/" . $u_id, '<i class="fa fa-pencil"></i>', "class='btn btn-info'");
            $action_html .= ' <a href="#" class="btn btn-danger delete_user" data-user-id ="' . $u_id . '" data-user-email ="' . $u_email . '" data-toggle="modal" data-target="#deleteUserModal"><i class="fa fa-trash"></i></a>';
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = $action_html;
        }
        echo json_encode($output_arr);
        die();
    }

    /**
     * Create a new user
     */
    public function create_user()
    {
        $this->data['page_title'] = ucwords(lang('create_user_heading'));
        $this->data['breadcrumb'] = array(
            'dashboard' => ucwords(lang('dashboard')),
            'user' => ucwords(lang('users')),
            'user/create_user' => ucwords(lang('create_user_heading'))
        );

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('user', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        $groups = $this->ion_auth->group($this->user_group_id)->result_array();
        $this->data['groups'] = $groups;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            ];
        }

        if ($this->form_validation->run() === TRUE && $insert_id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            // Only allow updating groups if user is admin
            if ($this->ion_auth->is_admin() && $insert_id > 0) {
                // Update the groups user belongs to
                $this->ion_auth->remove_from_group('', $insert_id);

                $groupData = $this->input->post('groups');
                if (isset($groupData) && !empty($groupData)) {
                    foreach ($groupData as $grp) {
                        $this->ion_auth->add_to_group($grp, $insert_id);
                    }
                }
            }
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('success', $this->ion_auth->messages());
            redirect("user", 'refresh');
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->session->set_flashdata('message', validation_errors());
            $this->render('create_user', 'admin');
        }
    }

    /**
     * Edit a user
     *
     * @param int|string $id
     */
    public function edit_user($id = '')
    {
        $this->data['page_title'] = ucwords(lang('edit_user_heading'));
        $this->data['breadcrumb'] = array(
            'dashboard' => ucwords(lang('dashboard')),
            'user' => ucwords(lang('users')),
            'user/edit_user' => ucwords(lang('edit_user_heading'))
        );

        if ($id == '' || !$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('user', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        if (!$user) {
            redirect('user', 'refresh');
        }
        $groups = $this->ion_auth->group(2)->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //USAGE NOTE - you can do more complicated queries like this
        //$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();


        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                ];

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }

                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    // Update the groups user belongs to
                    $this->ion_auth->remove_from_group('', $id);

                    $groupData = $this->input->post('groups');
                    if (isset($groupData) && !empty($groupData)) {
                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                    redirect('user', 'refresh');
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('user', 'refresh');
                }
            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', validation_errors());

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->render('edit_user', 'admin');
    }

    /**
     * Edit a user
     *
     * @param int|string $id
     */
    public function profile()
    {
        $this->data['page_title'] = ucwords(lang('edit_user_heading'));
        $this->data['breadcrumb'] = array(
            'dashboard' => ucwords(lang('dashboard')),
            'user/profile' => ucwords(lang('profile'))
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('user', 'refresh');
        }

        $id = $this->session->userdata('user_id');
        $user = $this->ion_auth->user()->row();
        if (!$user) {
            redirect('user', 'refresh');
        }

        //USAGE NOTE - you can do more complicated queries like this
        //$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();


        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                ];

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }

                if (!empty($_FILES['profile_pic']['name'])) {
                    if ($this->input->post('old_profile_pic') != ''  && file_exists(FCPATH . 'uploads/images/profile/' . $this->input->post('old_profile_pic'))) {
                        unlink(FCPATH . 'uploads/images/profile/' . $this->input->post('old_profile_pic'));
                    }
                    $newname = $this->upload_profile_pic();
                    $data['profile_pic'] = $newname;
                    $this->session->set_userdata(array('profile_pic' => $newname));
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                    redirect('user/profile', 'refresh');
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect('user/profile', 'refresh');
                }
            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', validation_errors());

        // pass the user to the view
        $this->data['user'] = $user;
        // $this->data['groups'] = $groups;
        // $this->data['currentGroups'] = $currentGroups;

        $this->render('profile', 'admin');
    }

    public function upload_profile_pic()
    {
        $filename = $_FILES['profile_pic']['name'];
        $tmpname = $_FILES['profile_pic']['tmp_name'];
        $exp = explode('.', $filename);
        $ext = end($exp);
        $newname =  $exp[0] . '_' . time() . "." . $ext;
        $config['upload_path'] = 'uploads/images/profile/';
        $config['upload_url'] =  base_url() . 'uploads/images/profile/';
        $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
        $config['max_size'] = '2000000';
        $config['file_name'] = $newname;
        $this->load->library('upload', $config);
        move_uploaded_file($tmpname, "uploads/images/profile/" . $newname);
        return $newname;
    }

    /**
     * Delete a user
     *
     * @param int|string $id
     */

    public function delete_user($id = '')
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', $this->ion_auth->messages());
            redirect('user', 'refresh');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('delete_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('delete_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() !== FALSE) {
            // do we really want to delete?
            if ($this->input->post('confirm') == 'yes') {
                $id = $this->input->post('id');

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->delete_user($id);
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                }
            }

            // redirect them back to the auth page
            redirect('user', 'refresh');
        } else {
            $this->session->set_flashdata('message', validation_errors());
            redirect('user', 'refresh');
        }
    }

    /**
     * Activate the user
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function activate($id, $code = FALSE)
    {
        $activation = FALSE;

        if ($code !== FALSE) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('success', $this->ion_auth->messages());
            redirect("user", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("user/forgot_password", 'refresh');
        }
    }

    /**
     * Deactivate the user
     *
     * @param int|string|null $id The user ID
     */
    public function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            show_error('You must be an administrator to view this page.');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() !== FALSE) {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                $id = $this->input->post('id');

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                }
            }

            // redirect them back to the auth page
            redirect('user', 'refresh');
        } else {
            $this->session->set_flashdata('message', validation_errors());
            redirect('user', 'refresh');
        }
    }

    /**
     * Forgot password
     */
    public function forgot_password()
    {
        $this->data['page_title'] = ucwords(lang('forgot_password_heading'));
        $this->data['breadcrumb'] = array(
            '/' => ucwords(lang('home')),
            'user/forgot_password' => ucwords(lang('forgot_password_heading'))
        );


        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() === FALSE) {

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->session->set_flashdata('message', validation_errors());
            $this->render('forgot_password', 'public');
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect("user/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect("user/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect("user/forgot_password", 'refresh');
            }
        }
    }

    /**
     * Reset password - final step for forgotten password
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $this->data['page_title'] = ucwords(lang('reset_password_heading'));
        $this->data['breadcrumb'] = array(
            '/' => ucwords(lang('home')),
            'user/reset_password' => ucwords(lang('reset_password_heading'))
        );

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            $this->data['user'] = $user;
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() === FALSE) {
                // display the form
                // set the flash data error message if there is one
                $this->session->flashdata('message', validation_errors());

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->render('user/reset_password', 'public');
            } else {
                $identity = $user->{$this->config->item('identity', 'ion_auth')};

                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($identity);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('success', $this->ion_auth->messages());
                        redirect("user/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect('user/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect("user/forgot_password", 'refresh');
        }
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
