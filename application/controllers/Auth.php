<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Akbr_auth_model');
  }

  public function index()
  {
    if ($this->session->userdata('email')) {
      redirect('dashboard');
    }
    $this->load->view('auth/login');
  }

  public function login()
  {
    // $this->akbr_auth->auth();

    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('error', 'Failed to login');
      $this->index();
    } else {
      $email = $this->input->post('email', TRUE);
      $password = $this->input->post('password', TRUE);

      // check email registered
      $user = $this->Akbr_auth_model->check_email($email);


      if ($user) {
        // check password
        // $check_password = password_verify($password, $user->password);

        if ($password == $user->password) {
          // set session
          $session = array(
            'user_id' => $user->id,
            'nama' => $user->nama,
            'departemen_id' => $user->departemen_id,
            'email' => $user->email,
            'is_login' => TRUE,
          );

          $this->session->set_userdata($session);

          $this->session->set_flashdata('success', 'Login success');
          redirect(site_url('dashboard'));
        } else {
          $this->session->set_flashdata('error', 'Wrong password');
          $this->index();
        }
      } else {
        $this->session->set_flashdata('error', 'Email not registered');
        $this->index();
      }
    }
  }

  public function register()
  {
    $this->akbr_auth->auth();

    $this->load->model('Akbr_roles_model');

    $roles = $this->Akbr_roles_model->get_all();
    $data = array(
      'title' => 'Tambah User',
      'titleapp' => config_item('title'),
      'descapp' => config_item('desc'),
      'socmed' => config_item('socmed'),
      'first_name' => set_value('first_name'),
      'last_name' => set_value('last_name'),
      'email' => set_value('email'),
      'role' => set_value('role'),
      'id_user' => set_value('id_user'),
      'roles' => $roles,
    );
    $data['message'] = '';


    $this->load->view('layout/header', $data);
    $this->load->view('auth/register', $data);
    $this->load->view('layout/footer', $data);
  }

  public function register_action()
  {
    $this->akbr_auth->auth();

    $this->_rules_create();

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('error', 'Pendaftaran gagal');
      $this->register();
    } else {
      // load config akbr
      $this->config->load('akbr');

      $first_name = $this->input->post('first_name', TRUE);
      $last_name = $this->input->post('last_name', TRUE);
      $email = $this->input->post('email', TRUE);
      $role = $this->config->item('default_role_id');
      $password = $this->input->post('password', TRUE);
      $password = password_hash($password, PASSWORD_DEFAULT);


      $data = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => $password,
        'role_id' => $role,
        'created_at' => strtotime(date('Y-m-d H:i:s')),
      );
      $this->load->model('Akbr_users_model');

      $this->Akbr_users_model->insert($data);

      $this->session->set_flashdata('success', 'Pendaftaran berhasil');
      redirect(site_url('Auth/register'));
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect(site_url('auth'));
  }

  public function _rules_create()
  {
    $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
    $this->form_validation->set_rules('last_name', 'last name', 'trim|required');
    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'password', 'min_length[8]|trim|required');
    $this->form_validation->set_rules('password_confirm', 'password confirmation', 'trim|required|matches[password]');
  }
}

/* End of file Auth.php */
