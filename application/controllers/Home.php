<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
    {
        parent::__construct();
		$this->load->model(array('Hom'));
    }
	public function index()
	{
		$this->load->view('home/header');	
		$this->load->view('home/home');	
		$this->load->view('home/footer');	
	}

	public function search(){
		$in = $this->input->get();
		$data = array();
		$data['result'] = $this->Hom->get_bus($in);
		//echo count($data['result']);die;
		$data['or']=$in['origin'];
		$data['ds']=$in['destination'];
		$data['dt']=$in['date'];
		//var_dump($data['result']);die;
		//var_dump($data['result'][0]);die;

		$this->load->view('home/header');	
		$this->load->view('home/search',$data);	
		$this->load->view('home/footer');	
	}
}