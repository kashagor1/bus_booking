<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct(){
		parent::__construct();
	    $this->load->model(['Dashboards']);

	}

    public function index()
    {
        if ($this->session->userdata['username']) {
            $this->load->view('dashboard/dash_header');
            $this->load->view('dashboard/index');
            $this->load->view('dashboard/dash_footer');
        } else {

            redirect(base_url('admin'));

        }

    }
    public function company(){
        if ($this->session->userdata['username']) {

          if (isset($_POST['company_name'])) {
           $this->Dashboards->create_company($_POST);
          }
          $data = array();
          $data['title']="Company";
          $data['headline']="Manage Company";

          $data['jsonResult'] = $this->Dashboards->list_company();

            $this->load->view('dashboard/dash_header',$data);
            $this->load->view('dashboard/company');
            $this->load->view('dashboard/c_list',$data);
            $this->load->view('dashboard/dash_footer');
        } else {

            redirect(base_url('admin'));

        }
    }
    public function company_edit(){
        $id = $this->input->POST('cid');
        $cl_msg= array();
        $company_info = $this->Dashboards->get_c_info($id);
        foreach($company_info as $cinfo){
            $cl_msg['id']=$cinfo['company_id'];
            $cl_msg['company_name'] = $cinfo['company_name'];
            $cl_msg['company_phone'] = $cinfo['company_phone'];
            $cl_msg['company_address'] = $cinfo['company_address'];
        }
        echo json_encode($cl_msg);
    }
    public function update_company(){
       

        if(isset($_POST)){
            $com_id= $this->input->post('company_id');
           $up_msg =  $this->Dashboards->update_c_info($com_id,$_POST);
            if($up_msg==='Success'){
                redirect(base_url('dashboard/company'));
            }else{
                redirect(base_url('dashboard/company'));
            }
                        
        }
    }
    public function delete_company(){
        $this->Dashboards->delete_company($_GET['id']);
        redirect(base_url('dashboard/company'));
    }



}