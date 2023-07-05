<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coach extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(['Dashboards', 'Coaach']);
  }
  public function index()
  {
    if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {


      $data = array();
      $data['title'] = "Add Coach";
      $data['headline'] = "Coaches";


      $this->load->view('dashboard/dash_header', $data);
      $this->load->view('dashboard/coach');
      $this->load->view('dashboard/dash_footer');
    } else {

      redirect(base_url('admin'));

    }

  }

  public function list_coach()
  {
    if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
      $data = array();
      $data['title'] = "Coach Lists";
      $data['headline'] = "Manage Coaches";
      $data['result'] = $this->Dashboards->coachlist();
      // var_dump($data['result']);die;
      $this->load->view('dashboard/dash_header', $data);
      $this->load->view('dashboard/coachlist', $data);
      $this->load->view('dashboard/dash_footer');

    } else {
      redirect(base_url('admin'));
    }
  }


  public function view_coach_info()
  {
    if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
      $data = array();
      $data['title'] = "Edit Coach";
      $data['headline'] = "Coach";
      $data['info'] = $this->Coaach->get_info($this->input->get('id'));
      $data['coach_id'] = $this->input->get('id');

      $this->load->view('dashboard/dash_header', $data);
      $this->load->view('dashboard/coach_edit', $data);
      $this->load->view('dashboard/dash_footer');
    } else {
      redirect(base_url('admin'));
    }
  }
  public function coach_info(){
    if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
      
      $id = $this->input->GET('id');
     
        $data =$this->Coaach->get_info($id);
        echo json_encode($data);
      
    } else {
      redirect(base_url('admin'));
    }
  }

  public function update_coach()
  {
    if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
      $data = $this->input->post();

      if ($this->Coaach->update_coach($data)) {
        $path = 'dashboard/view_coach_info?id=' . $data['coach_id'];
        redirect(base_url('dashboard/list_coach'));
      }
    } else {
      redirect(base_url('admin'));
    }
  }
  public function delete_coach()
  {
    if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
      $data = $this->input->get('id');

      if ($this->Coaach->delete_coach($data)) {
        redirect(base_url('dashboard/list_coach'));
      }
    } else {
      redirect(base_url('admin'));
    }
  }






  public function create_coach()
  {
    if ($this->session->userdata['username']) {
      $data = $this->input->post();
      if ($this->Dashboards->create_coach($data)) {
        $this->list_coach();
      } else {
        redirect(base_url('dashboard/coach'));
      }

    } else {
      redirect(base_url('admin'));
    }
  }

}