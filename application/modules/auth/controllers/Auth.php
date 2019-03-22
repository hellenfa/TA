<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Auth $auth
 * @property Ion_auth $ion_auth
 * @property Log_model $log_model
 * @property Ion_auth_model $ion_auth_model
 *
 */
class Auth extends MY_Controller
{
    // attr.
    private $data; // fix for HMVC

    // constr.
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'bs_helper'));
        $this->load->model('auth/ion_auth_model', 'ion_auth_model');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    public function index($start = 1)
    {
        $this->data['users'] = $this->ion_auth_model->get_users(($start - 1), 10);
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth_model->get_users_groups($user->id)->result();
        }
        $this->data['bc_view'] = 'auth/bc/index';
        $this->data['title'] = 'Kelola User';
        $this->data['kelola_user'] = 'active';

        /*
         * for pagination
         */
        $this->load->helper('pagination');
        $this->data["pagination"] = paginate('auth/index', $this->ion_auth_model->count_users(), 3, 10);

        $this->template->main('auth/index', $this->data);
    }

    // log the user in
    public function login()
    {
        $this->log_model->add($_SERVER['REMOTE_ADDR'], 'ACCESS LOGIN PAGE');
        $this->data['title'] = $this->lang->line('login_heading');
//        die(var_dump("as"));
        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        $dat = array(
            'id'       => $this->input->post('identity'),
            'password' => 'password'
        );

        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->input->post('remember');

            if ($this->ion_auth_model->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                $this->log_model->add($_SERVER['REMOTE_ADDR'], 'TRY LOGIN', 'SUCCESS', json_encode($dat));
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('notice', $this->ion_auth->messages());
                redirect('/', 'refresh');
            } else {
                array_push($dat, array('message' => 'Username atau password salah'));
                $this->log_model->add($_SERVER['REMOTE_ADDR'], 'TRY LOGIN', 'FAILED', json_encode($dat));

                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', 'Username atau password salah');
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            array_push($dat, array('message' => $this->data['message']));
            $this->log_model->add($_SERVER['REMOTE_ADDR'], 'TRY LOGIN', 'FAILED', json_encode($dat));

            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id'   => 'password',
                'type' => 'password',
            );

            $this->_render_page('auth/login', $this->data);
        }
    }

    // log the user out

    public function _render_page($view, $data = null, $returnhtml = false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) {
            return $view_html;
        }//This will return html on 3rd argument being true
    }

    // change password

    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name'    => 'new',
                'id'      => 'new',
                'type'    => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name'    => 'new_confirm',
                'id'      => 'new_confirm',
                'type'    => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );

            // render
            $this->_render_page('auth/change_password', $this->data);
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    // forgot password

    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('notice', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }

    // reset password - final step for forgotten password

    public function forgot_password()
    {
        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = array(
                'name' => 'identity',
                'id'   => 'identity',
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth/forgot_password', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }


    // activate the user

    public function reset_password($code = null)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                // display the form

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name'    => 'new',
                    'id'      => 'new',
                    'type'    => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name'    => 'new_confirm',
                    'id'      => 'new_confirm',
                    'type'    => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name'  => 'user_id',
                    'id'    => 'user_id',
                    'type'  => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth/reset_password', $this->data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === false || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // deactivate the user

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    // create a new user

    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return true;
        } else {
            return false;
        }
    }

    // edit a user

    public function activate($id, $code = false)
    {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // create a new group

    public function deactivate($id = null)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int)$id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == false) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();
            $this->data['title'] = lang('deactivate_heading');
            $this->data['kelola_user'] = 'active';
            $this->data['bc'] = '<li><a href="' . base_url() . '/auth">Kelola User</a></li><li class="active">Deactivate</li>';

            $this->template->main('auth/deactivate_user', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === false || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    // edit a group

    public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!empty($_POST) && $this->ion_auth_model->create_user($data)) {
            $email = strtolower($this->input->post('email'));

            $data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'instansi_id'  => $this->input->post('instansi'),
                'phone'        => $this->input->post('phone'),
                'password'     => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
            );

            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('notice', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            $this->data['instansi'] = $this->ion_auth_model->get_instansi();
            $this->data['content_view'] = 'auth/create_user';
            $this->data['bc_view'] = 'auth/bc/create_user';
            $this->data['kelola_user'] = 'active';

//			$this->template->main( $this->data);
            $this->load->view('auth/create_user', $this->data);
        }
    }

    public function edit_user($id)
    {
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        if (isset($_POST) && !empty($_POST)) {
            $data = array(
                'email'    => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'phone'    => $this->input->post('nomor_telepon'),
            );

            if ($this->input->post('password') != null) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }

            $this->ion_auth_model->update($user->id,$data);

            $this->session->set_flashdata('notice','Berhasil memperbaharui Profil');
            redirect('auth/edit_user/'.$user->id);
        } else {
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            // pass the user to the view
            $this->data['users'] = $user;
            $this->data['id'] = $id;

            $this->template->main('auth/edit_user', $this->data);
        }
    }

    public function change_image()
    {
        if (isset($_FILES) && !empty($_FILES)) {
            // delete old file
            $file_path = BASEPATH . '../public/profile_picture/' . $this->ion_auth->user()->row()->profile_picture;
            if(file_exists($file_path)){
                unlink(BASEPATH . '../public/profile_picture/' . $this->ion_auth->user()->row()->profile_picture);
            }
            $data = array();

            //Count total files
            $filesCount = count($_FILES['files']['name']);

            //Looping all files
            for ($i = 0; $i < $filesCount; $i++) {
                //Define new $_FILES array - $_FILES['file']
                $_FILES['file']['name'] = $_FILES['files']['name'];
                $_FILES['file']['type'] = $_FILES['files']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['files']['error'];
                $_FILES['file']['size'] = $_FILES['files']['size'];

                $path = $_FILES['files']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                //Set preference
                $config['upload_path'] = BASEPATH . '/../public/profile_picture';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size'] = 10000; //in kb

                //naming file in dir
                $this->load->helper('string');
                $config['file_name'] = random_string('alnum', 20) . '.' . $ext;

                //Load upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload file
                $this->upload->do_upload('file');

                //update file name in db
                $upload_data = $this->upload->data();
                $this->ion_auth_model->upload_profile_picture($this->ion_auth->user()->row()->id, array('profile_picture' => $config['file_name']));
            }

            if (!empty($uploadData)) {
                // Insert files data into the database
                $this->session->set_flashdata('notice', 'Berhasil mengunggah File');
                redirect($_SERVER["HTTP_REFERER"]);
            }
            $this->session->set_flashdata('warning', $this->upload->display_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            redirect('auth/edit_user/' . $this->ion_auth->user()->row()->id);
        }
    }

    public function create_group()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        // validate form input
        $val = array(
            array(
                'field' => 'nama_grup',
                'label' => 'Nama Grup',
                'rules' => 'required'
            ),
            array(
                'field' => 'deskripsi',
                'label' => 'Deskripsi',
                'rules' => 'required',
            ),
        );
        $this->form_validation->set_rules($val);

        if ($this->form_validation->run() == true) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('nama_grup'), $this->input->post('deskripsi'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('notice', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            if ($this->data['message'] != null) {
                $this->session->set_flashdata('error', $this->data['message']);
                redirect('auth/create_group');
            }
            $this->data['nama_grup'] = array(
                'name'  => 'nama_grup',
                'type'  => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('nama_grup'),
            );
            $this->data['deskripsi'] = array(
                'name'  => 'deskripsi',
                'type'  => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('deskripsi'),
            );

            $this->data['bc_view'] = 'auth/bc/create_group';
            $this->data['kelola_user'] = 'active';

            $this->template->main('auth/create_group', $this->data);
        }
    }

    public function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === true) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('notice', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name'    => 'group_name',
            'id'      => 'group_name',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name'  => 'group_description',
            'id'    => 'group_description',
            'type'  => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );
        $this->data['title'] = lang('edit_group_heading');
        $this->data['kelola_user'] = 'active';
        $this->data['bc'] = '<li><a href="' . base_url() . 'auth">Kelola User</a></li><li class="active">Ubah Grup</li>';

        $this->template->main('auth/edit_group', $this->data);
    }

    public function api_username()
    {
        $username = $this->input->get('username');
        $old_username = $this->input->get('old_username');
        $data = $this->ion_auth_model->get_user($username);

        if (isset($username) && $this->ion_auth->user()->row()->username == $username) {
            echo json_encode(true);
        } elseif ($data < 1) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
}
