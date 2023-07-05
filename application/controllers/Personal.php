<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Person'));

    }
    public function index()
    {
        echo "Home";
    }
    public function profile()
    {
        if ($this->session->userdata('username') == true) {


            if ($this->input->post()) {
                $this->Person->update_uinfo($this->input->post());
            }



            $user = $this->session->userdata('username');
            $data['info'] = $this->Person->get_uinfo($user);
            // var_dump($pinfo);die;
            $data['isLoggedin'] = true;
            $this->load->view('home/header', $data);
            $this->load->view('home/upprofile', $data);
            $this->load->view('home/footer');

        } else {
            redirect(base_url('login'));
        }
    }

    public function tickets()
    {
        if ($this->session->userdata('username') == true) {
            $user = $this->session->userdata('username');
            $data = array();
            $data['tickets'] = $this->Person->get_tickets($user);

            $data['isLoggedin'] = true;
            $this->load->view('home/header', $data);
            $this->load->view('home/tickets', $data);
            $this->load->view('home/footer');

        } else {
            redirect(base_url('login'));
        }
    }

    public function cancel_ticket()
    {
        if ($this->session->userdata['username']) {

            $data['user'] = $this->session->userdata['username'];
            $data['pnr'] = $this->input->get('pnr');
            if($this->Person->cancel_ticket($data)){
                redirect(base_url('refund'));
            }else{
                redirect(base_url('tickets'));
            }
        } else {
            redirect(base_url());
        }
    }
    public function refund()
    {
        if ($this->session->userdata['username']) {
            $user = $this->session->userdata('username');
            $data = array();
            $data['refunds'] = $this->Person->get_refundlist($user);

            $data['isLoggedin'] = true;
            $this->load->view('home/header', $data);
            $this->load->view('home/refund', $data);
            $this->load->view('home/footer');

        } else {
            redirect(base_url());
        }
    }

    public function print_ticket()
    {
        //$pnr = $this->input->get('pnr');
        if ($this->session->userdata['username']) {

            $data = array();
            $data['pnr'] = $this->input->get('pnr');
            $data['info'] = $this->Person->print_info($this->input->get('pnr'));


            // var_dump($data['coach']);die;
            //die;
            $ticket = "ticket_" . $data['pnr'] . ".pdf";

            $html = $this->load->view('dashboard/print_ticket', $data, true);


            $this->load->library('pdf');

            $dompdf = new Pdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'protrait');

            $dompdf->render();
            $dompdf->stream($ticket);



        } else {

            redirect(base_url('login'));

        }


    }

}