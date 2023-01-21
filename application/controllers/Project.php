<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{

  public $module = 'project';
  public $className = '';

  public function __construct()
  {
    parent::__construct();
    $this->load->model(['Project_model', 'Client_model']);
    $this->className = $this->router->fetch_class();
  }


  function index()
  {
    $project_name = ($this->input->post('project_name') != '') ? $this->input->post('project_name') : null;
    $client = ($this->input->post('client') != 'null') ? $this->input->post('client') : null;
    $status = ($this->input->post('status') != 'null') ? $this->input->post('status') : null;
    // print_r($status);
    // die;
    $projects = $this->Project_model->get_all($project_name, $client, $status);
    $clients = $this->Client_model->get_all();
    $data = array(
      'title' => "Project",
      'titleapp' => config_item('title'),
      'descapp' => config_item('desc'),
      'socmed' => config_item('socmed'),
      'projects' => $projects,
      'clients' => $clients,
      'q_project' => $project_name,
      'q_client' => $client,
      'q_status' => $status
    );
    $this->load->view('template/header', $data);
    $this->load->view($this->module . '/index', $data);
    $this->load->view('template/footer', $data);
  }

  function detail($id)
  {
    $project = $this->Project_model->get_by_id($id);
    $data = array(
      'title' => $this->module,
      'titleapp' => config_item('title'),
      'descapp' => config_item('desc'),
      'socmed' => config_item('socmed'),
      'project' => $project
    );
    $this->load->view('template/header', $data);
    $this->load->view($this->module . '/detail', $data);
    $this->load->view('template/footer', $data);
  }


  public function create()
  {
    $clients = $this->Client_model->get_all();
    $data = array(
      'title' => 'Tambah ' . $this->module,
      'id' => set_value('id'),
      'project_name' => set_value('project_name'),
      'client' => set_value('client'),
      'status' => set_value('status'),
      'project_start' => set_value('project_start'),
      'project_end' => set_value('project_end'),
      'action' => site_url($this->className . '/create_action'),
      'clients' => $clients
    );
    $this->load->view('template/header', $data);
    $this->load->view($this->module . '/form', $data);
    $this->load->view('template/footer', $data);
  }


  public function create_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('error', 'Fail to create ' . $this->module . ' data');
      $this->create();
    } else {
      $project_name = $this->input->post('project_name', TRUE);
      $client = $this->input->post('client', TRUE);
      $status = $this->input->post('status', TRUE);
      $project_start = $this->input->post('project_start', TRUE);
      $project_end = $this->input->post('project_end', TRUE);

      $data = array(
        'project_name' => $project_name,
        'client_id' => $client,
        'Project_status' => $status,
        'project_start' => $project_start,
        'project_end' => $project_end,
      );

      $this->Project_model->insert($data);

      $this->session->set_flashdata('success', 'Success to create ' . $this->module . ' data');
      redirect(site_url($this->className . ''));
    }
  }

  public function edit($id)
  {
    $clients = $this->Client_model->get_all();
    $project = $this->Project_model->get_by_id($id);
    $data = array(
      'title' => 'Edit ' . $this->module,
      'titleapp' => config_item('title'),
      'descapp' => config_item('desc'),
      'socmed' => config_item('socmed'),
      'project_name' => $project->project_name,
      'project_start' => $project->project_start,
      'project_end' => $project->project_end,
      'status' => $project->Project_status,
      'client' => $project->client_id,
      'clients' => $clients,
      'id' => $project->project_id,
      'action' => site_url($this->className . '/edit_action'),
    );

    $this->load->view('template/header', $data);
    $this->load->view($this->module . '/form', $data);
    $this->load->view('template/footer', $data);
  }

  public function edit_action()
  {

    $this->_rules();
    $id = $this->input->post('id', TRUE);
    if (isset($_POST) && !empty($_POST)) {
      if ($this->form_validation->run() === TRUE) {
        $data = array(
          'project_name' => $this->input->post('project_name', TRUE),
          'project_start' => $this->input->post('project_start', TRUE),
          'project_end' => $this->input->post('project_end', TRUE),
          'Project_status' => $this->input->post('status', TRUE),
          'client_id' => $this->input->post('client', TRUE),
        );
        // check to see if we are updating the user
        if ($this->Project_model->update($id, $data)) {
          // redirect them back to the admin page if admin, or to the base url if non admin
          $this->session->set_flashdata('success', $this->module . ' berhasil diupdate');
          redirect($this->className . '/edit/' . $id, 'refresh');
        } else {
          // redirect them back to the admin page if admin, or to the base url if non admin
          $this->session->set_flashdata('error', $this->module . ' gagal diupdate');
          redirect($this->className . '/edit/' . $id, 'refresh');
        }
      } else {
        $this->session->set_flashdata('error', 'Failed to update ' . $this->module);
        $this->edit($id);
      }
    } else {
      $this->session->set_flashdata('error', 'Failed to update ' . $this->module);
      $this->edit($id);
    }
  }

  public function delete($id)
  {
    $this->Project_model->delete($id);
    $this->session->set_flashdata('message', $this->module . ' berhasil dihapus');
    redirect($this->className . '');
  }

  public function delete_checkbox()
  {
    if (isset($_POST['delete_checkbox'])) {
      if (!empty($this->input->post('checkbox_value'))) {
        $data = $this->input->post('checkbox_value[]');
        foreach ($data as $value) {
          $this->delete($value);
        }
        $this->session->set_flashdata('success', 'Data berhasil di hapus!');
        redirect(site_url('project'));
      } else {
        $this->session->set_flashdata('error', 'pilih setidaknya satu data!');
        redirect(site_url('project'));
      }
    }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
    $this->form_validation->set_rules('client', 'Client', 'trim|required');
    $this->form_validation->set_rules('status', 'Status', 'trim|required');
  }
}

/* End of file project.php */
