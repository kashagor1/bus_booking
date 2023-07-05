<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct(){
		parent::__construct();
	    $this->load->model(['Dashboards','Person']);

	}

    public function index()
    {
      //  var_dump($this->session);die;
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            $this->load->view('dashboard/dash_header');
            $this->load->view('dashboard/index');
            $this->load->view('dashboard/dash_footer');
        } else {

            redirect(base_url('admin'));

        }

        
        
    }

    public function sendref(){
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            
            $pnr = $this->input->get('pnr');
            $this->Person->make_refund($pnr);
            redirect(base_url('dashboard/refund'));

        } else {

            redirect(base_url('admin'));

        }
    }
    public function ticket()
    {
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            $this->load->view('dashboard/dash_header');
            $this->load->view('dashboard/ticket');
            $this->load->view('dashboard/dash_footer');
           
        } else {

            redirect(base_url('admin'));

        }

        
    }

    public function refund()
    {
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            $data['refunds']=$this->Person->get_all_refundlist();
            $this->load->view('dashboard/dash_header');
            $this->load->view('dashboard/refund',$data);
            $this->load->view('dashboard/dash_footer');
           
        } else {

            redirect(base_url('admin'));

        }

        
    }
    public function company(){
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {

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
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            $id = $this->input->POST('cid');
            $cl_msg= array();
            $company_info = $this->Dashboards->get_c_info($id);
            foreach($company_info as $cinfo){
                $cl_msg['id']=$cinfo['company_id'];
                $cl_msg['company_name'] = $cinfo['company_name'];
                $cl_msg['company_phone'] = $cinfo['company_phone'];
                $cl_msg['company_address'] = $cinfo['company_address'];
            }
            //echo json_encode($cl_msg);
        }else{
            redirect(base_url('admin'));
        }
   
    }
    public function update_company(){
       
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            if(isset($_POST)){
                $com_id= $this->input->post('company_id');
               $up_msg =  $this->Dashboards->update_c_info($com_id,$_POST);
                if($up_msg==='Success'){
                    redirect(base_url('dashboard/company'));
                }else{
                    redirect(base_url('dashboard/company'));
                }
                            
            }
        }else{
            redirect(base_url('admin'));

        }
      
    }
    public function delete_company(){
        if ($this->session->userdata['username'] && $this->session->userdata['role_id'] ==='111') {
            $this->Dashboards->delete_company($_GET['id']);
            redirect(base_url('dashboard/company'));
        }else{
            redirect(base_url('admin'));

        }
     
    }



}