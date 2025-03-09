<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;

class Trip extends Controller
{
    protected $tripsModel;
    protected $session;
    protected $role_id;
    protected $com_id;
    protected $coachModel;
    protected $pdf; // Add this for the PDF library

    public function __construct()
    {
        $this->tripsModel = new \App\Models\Trips(); // Instantiate the model
        $this->coachModel = new \App\Models\Coaach(); // Instantiate the Coach model

        $this->session = \Config\Services::session();

        $this->role_id = $this->session->get("role_id");
        $this->com_id = $this->session->get('com_id');
        $options = new Options();
        $options->set('defaultFont', 'Helvetica'); // Optional: Set default font
        $this->pdf = new Dompdf($options);
    }

    public function index()
    {
        $data = [
            'title' => "Add Trip",
            'headline' => "Trips",
            'trip_id' => $this->tripsModel->get_trip_number(), // Use $this->tripsModel
        ];
        return view('dashboard/dash_header', $data)
            . view('dashboard/trip', $data)
            . view('dashboard/dash_footer');
    }

    public function create_trip()
    {
        $data = $this->request->getPost(); // Use $this->request->getPost()
        $coach = $this->coachModel->get_info($data['cc_route_id']);

        if (!$coach) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Coach not found.');
        }

        if ($coach['company_id'] != $this->com_id) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Unauthorized Action. This coach does not belong to your company.');
        }
        $this->tripsModel->create_trip($data); // Use $this->tripsModel
        return redirect()->to(base_url('dashboard/trip'));
    }

    public function cancel_trip()
    {
        $trip = $this->request->getGet('id'); // Use $this->request->getGet()
        $this->tripsModel->cancel_trip($trip); // Use $this->tripsModel
        return redirect()->to(base_url('dashboard/trip/list'));
    }

    public function list_trip()
    {
        $data = [
            'title' => "Lists Trip",
            'headline' => "Trips",
            'trips' => $this->tripsModel->get_trip_list(1), // Use $this->tripsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/trip_list', $data)
            . view('dashboard/dash_footer');
    }

    public function clist_trip()
    {
        $data = [
            'title' => "Cancelled  Trips",
            'headline' => "Trips",
            'trips' => $this->tripsModel->get_trip_list(0), // Use $this->tripsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/ctrip_list', $data)
            . view('dashboard/dash_footer');
    }

    public function view_trip_info()
    {
        $data = [
            'title' => "Trip Info",
            'headline' => "Trips",
            'tr_id' => $this->request->getGet('id'), // Use $this->request->getGet()
            'co_id' => $this->request->getGet('cid'),
            'coach' => $this->tripsModel->get_trip_info($this->request->getGet('cid')), // Use $this->tripsModel
            'seats' => $this->tripsModel->get_seats_info($this->request->getGet()), // Use $this->tripsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/view_trip', $data)
            . view('dashboard/dash_footer');

    }

    public function print_trip_info()
    {
        $data = [
            'tirp_no' => $this->request->getGet('id'),
            'coach' => $this->tripsModel->get_trip_info($this->request->getGet('cid')), // Use $this->tripsModel
            'seats' => $this->tripsModel->get_seats_info($this->request->getGet()), // Use $this->tripsModel
        ];

        $html = view('dashboard/print_trip', $data);

        // Use the injected $this->pdf library
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait'); // Corrected spelling: portrait
        $this->pdf->render();
        $this->pdf->stream("Trip_List.pdf");

    }
}