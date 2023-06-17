<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(array('Login'));

	}
	
	public function index()
	{
		echo 'admin';
	}
    public function login(){
        $this->load->view('admin/login');
    }
    

    public function auth(){
		$this->check_input();
		if(isset($_POST)){
			$data= $this->getData();
			if($this->form_validation->run($data)==true){
				$auth_res = $this->Login->checkUser($data);
				 $session_data = array(
					'username'=>$auth_res->username,
					'role_id'=>$auth_res->role_id
				 );
				 $this->session->set_userdata($session_data);
				 redirect('Dashboard');

			}else{
				$data = "Opps! Wrong Credentials!";
				$this->load->view('admin/login');
			}
		}
	}
	// public function auth(){
	// 	$this->check_input();
	// 	if(isset($_POST)){
	// 		$data = $this->getData();
	// 		if($this->form_validation->run($data)==true){
	// 			$auth_res = $this->Login->checkUser($data);
	// 			$session_data = array(
	// 				'username' => $auth_res->username,
	// 				'role_id' => $auth_res->role_id
	// 			);
	// 			$this->session->set_userdata($session_data);
	// 			redirect('Dashboard');
	// 		} else {
	// 			$data = "Opps! Wrong Credentials!";
	// 			$this->load->view('admin/login');
	// 		}
	// 	}
	// }
	

	public function getData(){
		$data = array();
		$data['user_name']=$this->input->post('user_name');
		$data['password']=$this->input->post('password');
		return $data;
	}
	public function check_input(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name', 'user_name', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
	
	}

}
