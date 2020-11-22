<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends App_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->app->is_db_upgrade_required()) {
            redirect(admin_url());
        }

        load_admin_language();
        $this->load->model('Authentication_model');
        $this->load->library('form_validation');

        $this->form_validation->set_message('required', _l('form_validation_required'));
        $this->form_validation->set_message('valid_email', _l('form_validation_valid_email'));
        $this->form_validation->set_message('matches', _l('form_validation_matches'));

        hooks()->do_action('admin_auth_init');
    }
public function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
    return array($first_name, $last_name);
}
public function convert_tourl($str) {
      $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
      $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
      $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
      $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
      $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
      $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
      $str = preg_replace("/(đ)/", "d", $str);
      $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
      $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
      $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
      $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
      $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
      $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
      $str = preg_replace("/(Đ)/", "D", $str);
      $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
      return $str;
  }
    public function index()
    {

        if(intval(@$this->session->userdata('data')->client_user_id)<=0){
            $bol=$this->db->query("SELECT users.*,dept.dept_name FROM users left join dept on dept.dept_id=users.dept_id where users.access_token='".@$_COOKIE['access_token']."' and users.access_token<>''");
            if($bol)
            $usn=@$bol->row_array();
            else
            $usn=array();

            if(is_array($usn) && count($usn)>0){
                $table = db_prefix() . 'staff';
                $this->db->where('email', $usn['email']);
                $user = $this->db->get($table)->row_array();

                if(is_array($user) && count($user)>0){

                $user_data = [
                        'staff_user_id'   => $user['staffid'],
                        'staff_logged_in' => true,
                ];
                $this->session->set_userdata($user_data);
                $this->authentication_model->create_autologin($user['staffid'], true);

                $tabledep = db_prefix() . 'departments';
                    $this->db->where('name', $usn['dept_name']);
                    $dep = $this->db->get($tabledep)->row_array();

                    if(is_array($dep) && count($dep)>0){
                        $dep_id=$dep['departmentid'];
                    }
                    else{
                        $ins=array();
                        $ins['name']=$usn['dept_name'];
                        $this->db->insert($tabledep,$ins);
                        $dep_id=$this->db->insert_id();
                    }
                $dep_id=intval(@$dep_id);
                    if($dep_id>0){
                        
                        $table_staffdep = db_prefix() . 'staff_departments';
                        $this->db->where('departmentid', $dep_id)->where('staffid', $user['staffid']);
                        $staffdep = $this->db->get($table_staffdep)->row_array();
                        if(is_array($staffdep) && count($staffdep)>0){

                        }
                        else
                        {
                            $ins=array();
                            $ins['staffid']=$user['staffid'];
                            $ins['departmentid']=$dep_id;
                            $this->db->insert(db_prefix().'staff_departments',$ins);
                        }

                    }
                }
                else
                {


                    $tabledep = db_prefix() . 'departments';
                    $this->db->where('name', $usn['dept_name']);
                    $dep = $this->db->get($tabledep)->row_array();

                    if(is_array($dep) && count($dep)>0){
                        $dep_id=$dep['departmentid'];
                    }
                    else{
                        $ins=array();
                        $ins['name']=$usn['dept_name'];
                        $this->db->insert($tabledep,$ins);
                        $dep_id=$this->db->insert_id();
                    }


                    $ins=array();
                    $fullname=$this->split_name($usn['full_name']);
                    $ins['firstname']=$fullname[0];
                    $ins['lastname']=$fullname[1];
                    $ins['facebook']='';
                    $ins['linkedin']='';
                    $ins['phonenumber']='';
                    $ins['skype']='';
                    $ins['email']=$usn['email'];
                    $ins['password']=$usn['password'];
                    $ins['datecreated']=date('Y-m-d H:i:s',time());
                    $ins['profile_image']='';
                    $ins['active']=1;
                    $ins['default_language']='vietnamese';
                    $ins['direction']='';
                    $ins['media_path_slug']=$this->convert_tourl($usn['full_name'])."-".$usn['user_id'].'-'.time();
                    $ins['is_not_staff']='0';
                    $ins['hourly_rate']='0';
                    $this->db->insert($table,$ins);
                    $staffid=$this->db->insert_id();

                    $dep_id=intval(@$dep_id);
                    if($dep_id>0){
                        $ins=array();
                        $ins['staffid']=$staffid;
                        $ins['departmentid']=$dep_id;
                        $this->db->insert(db_prefix().'staff_departments',$ins);
                    }

                }
                
            }
            else
            {

            }
        }
        $this->admin();
    }

    public function admin()
    {
        if (is_staff_logged_in()) {

            redirect(admin_url());
        }

        $this->form_validation->set_rules('password', _l('admin_auth_login_password'), 'required');
        $this->form_validation->set_rules('email', _l('admin_auth_login_email'), 'trim|required|valid_email');
        if (get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != '') {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');
        }
        if ($this->input->post()) {
            if ($this->form_validation->run() !== false) {
                $email    = $this->input->post('email');
                $password = $this->input->post('password', false);
                $remember = $this->input->post('remember');

                $data = $this->Authentication_model->login($email, $password, $remember, true);

                if (is_array($data) && isset($data['memberinactive'])) {
                    set_alert('danger', _l('admin_auth_inactive_account'));
                    redirect(admin_url('authentication'));
                } elseif (is_array($data) && isset($data['two_factor_auth'])) {
                    $this->Authentication_model->set_two_factor_auth_code($data['user']->staffid);

                    $sent = send_mail_template('staff_two_factor_auth_key', $data['user']);

                    if (!$sent) {
                        set_alert('danger', _l('two_factor_auth_failed_to_send_code'));
                        redirect(admin_url('authentication'));
                    } else {
                        set_alert('success', _l('two_factor_auth_code_sent_successfully', $email));
                    }
                    redirect(admin_url('authentication/two_factor'));
                } elseif ($data == false) {
                    set_alert('danger', _l('admin_auth_invalid_email_or_password'));
                    redirect(admin_url('authentication'));
                }

                $this->load->model('announcements_model');
                $this->announcements_model->set_announcements_as_read_except_last_one(get_staff_user_id(), true);

                // is logged in
                maybe_redirect_to_previous_url();

                hooks()->do_action('after_staff_login');
                redirect(admin_url());
            }
        }

        $data['title'] = _l('admin_auth_login_heading');
        $this->load->view('authentication/login_admin', $data);
    }

    public function two_factor()
    {
        $this->form_validation->set_rules('code', _l('two_factor_authentication_code'), 'required');

        if ($this->input->post()) {
            if ($this->form_validation->run() !== false) {
                $code = $this->input->post('code');
                $code = trim($code);
                if ($this->Authentication_model->is_two_factor_code_valid($code)) {
                    $user = $this->Authentication_model->get_user_by_two_factor_auth_code($code);
                    $this->Authentication_model->clear_two_factor_auth_code($user->staffid);
                    $this->Authentication_model->two_factor_auth_login($user);

                    $this->load->model('announcements_model');
                    $this->announcements_model->set_announcements_as_read_except_last_one(get_staff_user_id(), true);

                    maybe_redirect_to_previous_url();

                    hooks()->do_action('after_staff_login');
                    redirect(admin_url());
                } else {
                    set_alert('danger', _l('two_factor_code_not_valid'));
                    redirect(admin_url('authentication/two_factor'));
                }
            }
        }
        $this->load->view('authentication/set_two_factor_auth_code');
    }

    public function forgot_password()
    {
        if (is_staff_logged_in()) {
            redirect(admin_url());
        }
        $this->form_validation->set_rules('email', _l('admin_auth_login_email'), 'trim|required|valid_email|callback_email_exists');
        if ($this->input->post()) {
            if ($this->form_validation->run() !== false) {
                $success = $this->Authentication_model->forgot_password($this->input->post('email'), true);
                if (is_array($success) && isset($success['memberinactive'])) {
                    set_alert('danger', _l('inactive_account'));
                    redirect(admin_url('authentication/forgot_password'));
                } elseif ($success == true) {
                    set_alert('success', _l('check_email_for_resetting_password'));
                    redirect(admin_url('authentication'));
                } else {
                    set_alert('danger', _l('error_setting_new_password_key'));
                    redirect(admin_url('authentication/forgot_password'));
                }
            }
        }
        $this->load->view('authentication/forgot_password');
    }

    public function reset_password($staff, $userid, $new_pass_key)
    {
        if (!$this->Authentication_model->can_reset_password($staff, $userid, $new_pass_key)) {
            set_alert('danger', _l('password_reset_key_expired'));
            redirect(admin_url('authentication'));
        }
        $this->form_validation->set_rules('password', _l('admin_auth_reset_password'), 'required');
        $this->form_validation->set_rules('passwordr', _l('admin_auth_reset_password_repeat'), 'required|matches[password]');
        if ($this->input->post()) {
            if ($this->form_validation->run() !== false) {
                hooks()->do_action('before_user_reset_password', [
                    'staff'  => $staff,
                    'userid' => $userid,
                ]);
                $success = $this->Authentication_model->reset_password($staff, $userid, $new_pass_key, $this->input->post('passwordr', false));
                if (is_array($success) && $success['expired'] == true) {
                    set_alert('danger', _l('password_reset_key_expired'));
                } elseif ($success == true) {
                    hooks()->do_action('after_user_reset_password', [
                        'staff'  => $staff,
                        'userid' => $userid,
                    ]);
                    set_alert('success', _l('password_reset_message'));
                } else {
                    set_alert('danger', _l('password_reset_message_fail'));
                }
                redirect(admin_url('authentication'));
            }
        }
        $this->load->view('authentication/reset_password');
    }

    public function set_password($staff, $userid, $new_pass_key)
    {
        if (!$this->Authentication_model->can_set_password($staff, $userid, $new_pass_key)) {
            set_alert('danger', _l('password_reset_key_expired'));
            if ($staff == 1) {
                redirect(admin_url('authentication'));
            } else {
                redirect(site_url('authentication'));
            }
        }
        $this->form_validation->set_rules('password', _l('admin_auth_set_password'), 'required');
        $this->form_validation->set_rules('passwordr', _l('admin_auth_set_password_repeat'), 'required|matches[password]');
        if ($this->input->post()) {
            if ($this->form_validation->run() !== false) {
                $success = $this->Authentication_model->set_password($staff, $userid, $new_pass_key, $this->input->post('passwordr', false));
                if (is_array($success) && $success['expired'] == true) {
                    set_alert('danger', _l('password_reset_key_expired'));
                } elseif ($success == true) {
                    set_alert('success', _l('password_reset_message'));
                } else {
                    set_alert('danger', _l('password_reset_message_fail'));
                }
                if ($staff == 1) {
                    redirect(admin_url('authentication'));
                } else {
                    redirect(site_url());
                }
            }
        }
        $this->load->view('authentication/set_password');
    }

    public function logout()
    {
        $this->Authentication_model->logout();
        hooks()->do_action('after_user_logout');
        redirect(admin_url('authentication'));
    }

    public function email_exists($email)
    {
        $total_rows = total_rows(db_prefix().'staff', [
            'email' => $email,
        ]);
        if ($total_rows == 0) {
            $this->form_validation->set_message('email_exists', _l('auth_reset_pass_email_not_found'));

            return false;
        }

        return true;
    }

    public function recaptcha($str = '')
    {
        return do_recaptcha_validation($str);
    }
}
