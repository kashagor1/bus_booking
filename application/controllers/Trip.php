<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trip extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Trips']);
    }
    public function index()
    {
        if ($this->session->userdata['username']) {


            $data = array();
            $data['title'] = "Add Trip";
            $data['headline'] = "Trips";

            $data['trip_id'] = $this->Trips->get_trip_number();


            $this->load->view('dashboard/dash_header', $data);
            $this->load->view('dashboard/trip', $data);
            $this->load->view('dashboard/dash_footer');
        } else {

            redirect(base_url('admin'));

        }
    }

    public function create_trip()
    {

        if ($this->session->userdata['username']) {
            $data = $this->input->post();
            $this->Trips->create_trip($data);
            redirect(base_url('dashboard/trip'));
        } else {

            redirect(base_url('admin'));

        }
    }
    public function list_trip()
    {

        if ($this->session->userdata['username']) {
            $data = array();
            $data['title'] = "Lists Trip";
            $data['headline'] = "Trips";

            $data['trips'] = $this->Trips->get_trip_list();
            //die;

            $this->load->view('dashboard/dash_header', $data);
            $this->load->view('dashboard/trip_list', $data);
            $this->load->view('dashboard/dash_footer');
        } else {

            redirect(base_url('admin'));

        }
    }

    public function view_trip_info()
    {
        if ($this->session->userdata['username']) {
            $data = array();
            $data['title'] = "Trip Info";
            $data['headline'] = "Trips";
            $data['tr_id'] =$this->input->get('id');
            $data['co_id'] =$this->input->get('cid');

            $data['coach'] = $this->Trips->get_trip_info($this->input->get('cid'));
            $data['seats'] = $this->Trips->get_seats_info($this->input->get());
            //var_dump($data['seats']);die;
            //die;

            $this->load->view('dashboard/dash_header', $data);
            $this->load->view('dashboard/view_trip', $data);
            $this->load->view('dashboard/dash_footer');
        } else {

            redirect(base_url('admin'));

        }

    }
    public function print_trip_info()
    {
        if ($this->session->userdata['username']) {

            $data = array();
            $data['tirp_no'] = $this->input->get('id');

            $data['coach'] = $this->Trips->get_trip_info($this->input->get('cid'));
            $data['seats'] = $this->Trips->get_seats_info($this->input->get());
            // var_dump($data['coach']);die;
            //die;

          $html =  $this->load->view('dashboard/print_trip',$data,true);

           
		$this->load->library('pdf');

		$dompdf =new Pdf();
		$dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'protrait');

		$dompdf->render();
		$dompdf->stream("Trip_List.pdf");
   


        } else {

            redirect(base_url('admin'));

        }

    }


}