<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Hom', 'Seats', 'Route'));
	}
	public function index()
	{
		$isLoggedin = false;
		if ($this->session->userdata('username')==true) {
			$isLoggedin = true;
		} else {
			$isLoggedin = false;
		}
		
		$data = array();
		$data['isLoggedin'] = $isLoggedin;
		//var_dump($data);die;
		$this->load->view('home/header', $data);
		$this->load->view('home/home');
		$this->load->view('home/footer');
	}

	public function search()
	{
		$isLoggedin = false;
		if ($this->session->userdata('username')==true) {
			$isLoggedin = true;
		} else {
			$isLoggedin = false;
		}
		$in = $this->input->get();
		$data = array();
		$currentDate = date('Y-m-d');
		$inputDate = $in['date'];
		$next7Days = date('Y-m-d', strtotime('+7 days'));
		
		if ($inputDate >= $currentDate && $inputDate <= $next7Days) {
			$data['result'] = $this->Hom->get_bus($in);
		} else {
			$data['result'] = NULL;
		}
		

		//var_dump($data['result']);die;
		//echo count($data['result']);die;
		$data['or'] = $in['origin'];
		$data['ds'] = $in['destination'];
		$data['dt'] = $in['date'];
		$data['isLoggedin'] = $isLoggedin;

		//var_dump($data['result']);die;
		//var_dump($data['result'][0]);die;

		$this->load->view('home/header',$data);
		$this->load->view('home/search', $data);
		$this->load->view('home/footer');
	}
	public function seatselection()
	{
		$indata = json_decode($this->input->post('params'), true);
		$this->session->unset_userdata('booking_data');


		$isLoggedin = false;
		if ($this->session->userdata('username')==true) {
			$isLoggedin = true;
		} else {
			$isLoggedin = false;
		}
		//var_dump($this->input->post('params'));die;
		//var_dump($indata);die;
		//var_dump($indata);die;
		$data['origin'] = base64_decode($indata['origin']);
		$data['destination'] = base64_decode($indata['destination']);
		$data['fare'] = $indata['fare'];
		$data['trip_id'] = $indata['trip_id'];
		$data['coach_id'] = $indata['coach_id'];
		$data['route_id'] = $indata['route_id'];
		$data['date'] = $indata['date'];
		$data['isLoggedin'] = $isLoggedin;

		//$data['results'] = $this->Seats->all_seats($indata['coach_id']);
		$data['results'] = $this->Seats->booked_seats($indata['trip_id']);

		$data['froute'] = $this->Route->get_full_route($indata['route_id']);
		$ds = $this->Seats->get_all_info($indata['coach_id']);
		$data['info'] = $ds[0];
		//var_dump($data['info']);die;
		//	var_dump($data['info']);die;
		// echo "<pre>";
		// print_r($data['results']);die;
		//var_dump($data['results']);die;

		//var_dump($indata);die;
		$this->load->view('home/header',$data);
		$this->load->view('seatsl/viewseats', $data);
		$this->load->view('seatsl/seats', $data);
		$this->load->view('seatsl/footer');
	}
	public function login()
	{
		//var_dump($this->session);die;role_id
		if(!$this->session->userdata('username')){
			
			$rs = $this->input->post();
			$data = array();
			$data['isLoggedin'] = false;
			$this->load->view('home/header', $data);
			$this->load->view('home/lorform');
			$this->load->view('home/footer');
			if($rs){
				$rs['loginPassword'] = md5($rs['loginPassword']);
				if($this->Hom->slogin($rs)){
					$this->session->set_userdata('username', $rs['loginUsername']);

					redirect(base_url());

				}else{
					redirect(base_url('login'));
				}
			}

		}else if($this->session->userdata('role_id')=='111'){
			$this->session->sess_destroy();
			redirect(base_url('login'));
		}
		else{
			redirect(base_url());
		}
		$rs = $this->input->post();
		$data['isLoggedin'] = false;
		// $this->load->view('home/header', $data);
		// $this->load->view('home/lorform');
		// $this->load->view('home/footer');
		// if ($rs) {
		// 	$rs['loginPassword'] = md5($rs['loginPassword']);
		// }
		// if ($this->session->userdata('username')) {
		// 	redirect(base_url('login'));

		// } else if ($this->Hom->slogin($rs)) {

			 
		// 		$this->session->set_userdata('username', $rs['loginUsername']);
		// 		redirect(base_url('home'));

			
		// }


	}

	public function logout(){

		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function midform()
	{
		$oda= array();
		$isLoggedin = false;
		if ($this->session->userdata('username')==true) {
			$isLoggedin = true;
		} else {
			$isLoggedin = false;
		}
		$oda['isLoggedin']=$isLoggedin;
		$data = $this->input->post();
		//var_dump($data);die;
		if (!$this->session->userdata('booking_data')) {
			$ata = array(
				'selected_seats' => $data['seats'],
				'coach_id' => $data['coach_id'],
				'trip_id' => $data['trip_id'],
				'route_id' => $data['route_id'],
				'fare' => $data['fare'],
				'origin' => $data['origin'],
				'destination' => $data['destination'],
				'date' => $data['date']
			);
			$this->session->set_userdata('booking_data', $ata);
		}
		//	var_dump($this->session);

		if ($this->session->userdata('username')) {
			redirect(base_url('fillinfo'));
		} else {
			$this->load->view('home/header',$oda);
			$this->load->view('seatsl/lorform');
			$this->load->view('seatsl/footer');
		}

	}


	public function payment()
	{
		//var_dump($this->session->userdata);die;
		$oda= array();
		$isLoggedin = false;
		if ($this->session->userdata('username')==true) {
			$isLoggedin = true;
		} else {
			$isLoggedin = false;
		}
		$oda['isLoggedin']=$isLoggedin;
		
		$dat = $this->input->post();
		$this->session->set_userdata('personal_info', $dat);
		//		var_dump($this->session->userdata);die;
		$this->load->view('home/header',$oda);
		$this->load->view('seatsl/step2');
		$this->load->view('seatsl/footer');
	}
	public function process_payment()
	{


		$post = $this->session->userdata;
		if ($this->Hom->process_payment($post)) {
			redirect(base_url('tickets'));
		} else {
			redirect(base_url());
		}
	}

	public function fillinfo()
	{
		$oda= array();
		$isLoggedin = false;
		if ($this->session->userdata('username')==true) {
			$isLoggedin = true;
		} else {
			$isLoggedin = false;
		}
		$oda['isLoggedin']=$isLoggedin;
		$bookingData = $this->session->userdata('booking_data');
		//var_dump($bookingData);
		$this->load->view('home/header',$oda);
		$this->load->view('seatsl/step1', $bookingData);
		$this->load->view('seatsl/footer');


	}

	public function slogin()
	{
		$rs = $this->input->post();
		$rs['loginPassword'] = md5($rs['loginPassword']);

		if ($this->Hom->slogin($rs)) {
			$this->session->set_userdata('username', $rs['loginUsername']);
			redirect(base_url('fillinfo'));

		} else {
			redirect(base_url('midform'));
		}


	}
	public function newreg()
	{
		$rs = $this->input->post();
		//var_dump($rs);
		$cr_res = $this->Hom->register_user($rs);
		if ($cr_res) {
			$this->session->set_userdata('username', $rs['email']);
			redirect(base_url());
		} else {
			redirect(base_url('login'));
		}

	}
	public function register()
	{
		$rs = $this->input->post();
		if($rs){
			$cr_res = $this->Hom->register_user($rs);
			if ($cr_res) {
				$this->session->set_userdata('username', $rs['email']);
				redirect(base_url('fillinfo'));
			} else {
				redirect(base_url('midform'));
			}
		}else{
			redirect(base_url());
		}
		

	}
}