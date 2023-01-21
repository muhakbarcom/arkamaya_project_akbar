<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Akbr_auth_model extends CI_Model
{
  public $table = 'tb_m_users';
  public $id = 'id';
  public $order = 'DESC';

  function __construct()
  {
    parent::__construct();
  }

  // check email
  function check_email($email)
  {
    $this->db->where('email', $email);
    return $this->db->get($this->table)->row();
  }

  public function login($email, $password)
  {
    $this->db->where('email', $email);
    $this->db->where('password', $password);
    $result = $this->db->get('users')->row();
  }

  public function recheck_session()
  {
    if (empty($this->session->userdata('email'))) {
      return FALSE;
    } else {
      if ($this->session->userdata('is_login') == 1) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
  }
}

/* End of file Akbr_auth_model.php */
