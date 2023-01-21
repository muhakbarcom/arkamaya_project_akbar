<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project_model extends CI_Model
{
  public $table = 'tb_m_project';
  public $id = 'project_id';
  public $order = 'DESC';

  function __construct()
  {
    parent::__construct();
  }

  // get all
  function get_all($project_name = null, $client = null, $status = null)
  {

    $this->db->join('tb_m_client', 'tb_m_client.client_id = tb_m_project.client_id');
    if ($project_name != null) {
      $this->db->like('tb_m_project.project_name', $project_name);
    }
    if ($client != null) {
      $this->db->like('tb_m_client.client_name', $client);
    }
    if ($status != null) {
      $this->db->like('tb_m_project.Project_status', $status);
    }
    $this->db->order_by($this->id, $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_project($limit, $start, $search = null)
  {
    if ($search != null) {
      $this->db->or_like('project_name', $search);
    }
    $this->db->order_by($this->id, $this->order);
    $this->db->limit($limit, $start);
    return $this->db->get($this->table)->result();
  }

  function get_project_limit($limit)
  {
    $this->db->order_by($this->id, $this->order);
    $this->db->limit($limit);
    return $this->db->get($this->table)->result();
  }

  // get data by id
  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  // insert
  function insert($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  // update
  function update($id, $data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);

    if ($this->db->affected_rows() > 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  // delete
  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }
}

/* End of file project_model.php */
