<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Routes extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Route'));



  }
  public function index()
  {
    if ($this->session->userdata['username']) {


      $data = array();
      $data['title'] = "Routes";
      $data['headline'] = "Add Routes";
      $data['route_id'] = $this->Route->get_route();

      $this->load->view('dashboard/dash_header', $data);
      $this->load->view('dashboard/routes',$data);
      $this->load->view('dashboard/dash_footer');
    } else {

      redirect(base_url('admin'));

    }

  }
  public function list_route()
  {
    $data = array();
    $data['title'] = "Routes List";
    $data['headline'] = "Manage Routes";

    $data['jsonResult'] = $this->Route->list_routes();

    $this->load->view('dashboard/dash_header', $data);
    $this->load->view('dashboard/r_list', $data);
    $this->load->view('dashboard/dash_footer');

  }
 

  public function create_route()
  {

    if ($this->Route->cr_route($_POST)) {
      redirect(base_url('dashboard/routes'));
    }

  }


  public function route_edit()
  {
    $id = $this->input->POST('cid');
    $cl_msg = array();
    $company_info = $this->Route->get_r_info($id);
    foreach ($company_info as $cinfo) {
      $cl_msg['id'] = $cinfo['id'];
      $cl_msg['route_name'] = $cinfo['route_name'];
      $cl_msg['point_type'] = $cinfo['point_type'];
      $cl_msg['fare'] = $cinfo['fare'];
    }
    echo json_encode($cl_msg);
  }
  public function up_route()
  {
    $id = $this->input->POST('re_id');
    $r_info = $this->Route->get_r_info($id);
    $data = array();
    $data['id'] = $id;

    foreach ($r_info as $r) {
      if ($r['route_name'] != $this->input->post('r_name')) {
        $data['field'] = 'route_name';
        $data['val'] = $this->input->post('r_name');
        $this->Route->up_r($data);
      }
      if ($r['fare'] != $this->input->post('r_fare')) {
        $data['field'] = 'fare';
        $data['val'] = $this->input->post('r_fare');
        $this->Route->up_r($data);

      }
      if ($r['point_type'] != $this->input->post('destination_type')) {
        $data['field'] = 'point_type';
        $data['val'] = $this->input->post('destination_type');
        $this->Route->up_r($data);

      }
    }
    redirect(base_url('dashboard/list_route2'));


  }
  public function del_route()
  {
    $id = $this->input->get('id');
    $this->Route->del_route($id);
    redirect(base_url('dashboard/list_route2'));

  }
  public function del_w_route()
  {
    $id = $this->input->get('id');
    $this->Route->del_w_route($id);
    redirect(base_url('dashboard/list_route2'));

  }



  /* New List Routes Options */
  public function list_route2()
  {
    $data = array();
    $data['title'] = "Routes List";
    $data['headline'] = "Manage Routes";

    $data['routes'] = $this->Route->list_routes2();

    $this->load->view('dashboard/dash_header', $data);
    $this->load->view('dashboard/r_list2', $data);
    $this->load->view('dashboard/dash_footer');

  }
  public function view_full_route()
  {
    $data = array();
    $data['title'] = "Routes List";
    $data['headline'] = "Manage Routes";
    $id = $this->input->get('id');

   $data['results'] = $this->Route->get_full_route($id);
  
    $this->load->view('dashboard/dash_header',$data);

    $this->load->view('dashboard/edit_routes',$data);
    $this->load->view('dashboard/dash_footer');

  }
  
 

  public function update_route(){
    $data = $this->input->post();
   
    for ($i = 0; $i < count($data['id']); $i++) {
    
      $up_data = array();
      $up_data['id'] = $data['id'][$i];
      $up_data['route_id'] = $data['route_id'][$i];
      $up_data['route_name'] = $data['route_name'][$i];
      $up_data['or_id'] = $data['or_id'][$i];
      $up_data['fare'] = $data['fare'][$i];
      $up_data['point_type'] = $data['destination_type'][$i];
      if( $up_data['point_type']==1 ||  $up_data['point_type'] ==0){
        $this->Route->update_coach($up_data);
      }
      $this->Route->update_bulk_route($up_data);
      // Update the route table
      // Execute the query using your preferred method (e.g., mysqli_query, PDO, etc.)
  }
    redirect(base_url('dashboard/list_route2'));
   
  }
  


}