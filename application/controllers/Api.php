<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends RestController
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Akbr_auth_model');
  }

  public function login_post()
  {
    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'message' => 'Failed to login'
      ], 404);
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
            'email' => $user->email,
            'is_login' => TRUE,
          );

          $this->session->set_userdata($session);

          $this->response([
            'status' => true,
            'message' => 'Login success'
          ], 200);
          redirect(site_url('dashboard'));
        } else {
          $this->response([
            'status' => false,
            'message' => 'Wrong password'
          ], 404);
        }
      } else {
        $this->response([
          'status' => false,
          'message' => 'Email not registered'
        ], 404);
      }
    }
  }
}

/* End of file Api.php */
