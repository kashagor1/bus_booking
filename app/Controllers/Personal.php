<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class Personal extends Controller
{
    protected $personModel;
    protected $session;
    protected $pdf;

    public function __construct()
    {
        $this->personModel = new \App\Models\Person(); // Instantiate the model
        $this->session = \Config\Services::session();
        $options = new Options();
        $options->set('defaultFont', 'Helvetica'); // Optional: Set default font
        $this->pdf = new Dompdf($options);
    }

    public function index()
    {
        echo "Home"; // Or redirect, or load a view if you want something on the /personal route.
    }

    public function profile()
    {
        // echo "This is profile and die";die;

        if ($this->session->get('username')) {
            if ($this->request->getPost()) { // Use $this->request->getPost()
                $this->personModel->update_uinfo($this->request->getPost()); // Use $this->personModel
            }

            $user = $this->session->get('username');
            $data['title'] = 'Profile Page';
            $data = [
                'info' => $this->personModel->get_uinfo($user), // Use $this->personModel
                'isLoggedin' => true,
            ];
            $data['role_id'] = $this->session->get('role_id');

            return view('home/header', $data)
                . view('home/upprofile', $data)
                . view('home/footer');
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function tickets()
    {
        if ($this->session->get('username')) {
            $user = $this->session->get('username');
            $data = [
                'tickets' => $this->personModel->get_tickets($user), // Use $this->personModel
                'isLoggedin' => true,
            ];
            $data['role_id'] = $this->session->get('role_id');

            return view('home/header', $data)
                . view('home/tickets', $data)
                . view('home/footer');
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function cancel_ticket()
    {
        if ($this->session->get('username')) {
            $data = [
                'user' => $this->session->get('username'),
                'pnr' => $this->request->getGet('pnr'), // Use $this->request->getGet()
            ];
            if ($this->personModel->cancel_ticket($data)) { // Use $this->personModel
                return redirect()->to(base_url('personal/refund'));
            } else {
                // Handle the case where cancellation fails.  Important!
                $this->session->setFlashdata('error', 'Ticket cancellation failed.'); // Example with flash message
                return redirect()->to(base_url('personal/tickets'));
            }
        } else {
            return redirect()->to(base_url());
        }
    }

    public function refund()
    {
        if ($this->session->get('username')) {
            $user = $this->session->get('username');
            $data = [
                'refunds' => $this->personModel->get_refundlist($user), // Use $this->personModel
                'isLoggedin' => true,
            ];
            $data['role_id'] = $this->session->get('role_id');

            return view('home/header', $data)
                . view('home/refund', $data)
                . view('home/footer');
        } else {
            return redirect()->to(base_url());
        }
    }

    public function print_ticket()
    {
        if ($this->session->get('username')) {
            $data = [
                'pnr' => $this->request->getGet('pnr'), // Use $this->request->getGet()
                'info' => $this->personModel->print_info($this->request->getGet('pnr')), // Use $this->personModel
            ];

            $ticket = "ticket_" . $data['pnr'] . ".pdf";

            $html = view('dashboard/print_ticket', $data);

            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait'); // Corrected spelling
            $this->pdf->render();
            $this->pdf->stream($ticket);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
}