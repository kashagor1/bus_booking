<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	public function index()
	{
        $this->load->view('dashboard/dash_header');
        $this->load->view('dashboard/index');
        $this->load->view('dashboard/dash_footer');


    	}
    public function login(){
        $this->load->view('admin/login');
    }
    
    

}
