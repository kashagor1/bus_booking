<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(array('Districts'));

	}
    public function index(){
        $district = $this->Districts->getList();

    }
	public function route_info(){
	
		$ni = $this->input->post('id');
       $this->Districts->get_all_roi($ni);

    }
}