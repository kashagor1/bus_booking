<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Coach extends Controller
{
    protected $dashboardsModel;
    protected $coachModel; // Renamed for clarity

    protected $routeModel;
    protected $session;

    protected $role_id;
    protected $com_id;

    public function __construct()
    {
        $this->dashboardsModel = new \App\Models\Dashboards();
        $this->coachModel = new \App\Models\Coaach(); // Use correct model name and namespace
        $this->routeModel = new \App\Models\Route();
        $this->session = \Config\Services::session();
        $this->role_id = $this->session->get("role_id");
        $this->com_id = $this->session->get('com_id');
    }

    public function index()
    {

        $data = [
            'title' => "Add Coach",
            'headline' => "Coaches",
            'com_id' => $this->com_id
        ];
        return view('dashboard/dash_header', $data) . view('dashboard/coach') . view('dashboard/dash_footer');

    }

    public function list_coach()
    {
        $data = [
            'title' => "Coach Lists",
            'headline' => "Manage Coaches",
            'result' => $this->dashboardsModel->coachlist($this->com_id), // Use $this->dashboardsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/coachlist', $data)
            . view('dashboard/dash_footer');
    }

    public function view_coach_info()
    {
        $id = $this->request->getGet('id'); // Use $this->request->getGet()

        $coach = $this->coachModel->get_info($id);

        if ($coach['company_id'] != $this->com_id) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Unauthorized coach does not belong to your company!!!!');
        }
        $data = [
            'title' => "Edit Coach",
            'headline' => "Coach",
            'info' => $this->coachModel->get_info($id), // Use $this->coachModel
            'coach_id' => $id,
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/coach_edit', $data)
            . view('dashboard/dash_footer');
    }

    public function coach_info()
    {
        $id = $this->request->getGet('id'); // Use $this->request->getGet()
        $data = $this->coachModel->get_info($id); // Use $this->coachModel
        return $this->response->setJSON($data); // Return JSON response
    }
    public function update_coach()
    {
        $data = $this->request->getPost(); // Get post data

        // Check if the necessary data is provided

        // Check if coach exists
        $coach = $this->coachModel->get_info($data['coach_id']);

        if (!$coach || $data['final_destination'] == "Unauthorized") {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Coach not found.');
        }

        // Check if the coach belongs to the current company
        if ($coach['company_id'] != $this->com_id) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Unauthorized Action. This coach does not belong to your company.');
        }

        // Proceed with the update
        if ($this->coachModel->update_coach($data)) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('success', 'Coach updated successfully.');
        } else {
            $this->session->setFlashdata('error', 'Coach update failed.');
            return redirect()->back(); // Redirect back to the form with an error message.
        }
    }



    public function delete_coach()
    {
        $id = $this->request->getGet('id'); // Use $this->request->getGet()

        if (empty($id)) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'No coach ID provided.');
        }

        $coach = $this->coachModel->get_info($id);

        if (!$coach) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Coach not found.');
        }

        if ($coach['company_id'] != $this->com_id) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('error', 'Unauthorized Action. This coach does not belong to your company.');
        }

        if ($this->coachModel->delete_coach($id)) {
            return redirect()->to(base_url('dashboard/coach/list'))->with('success', 'Coach deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Coach delete failed.');
            return redirect()->back(); // Redirect back to the list.
        }
    }


    public function create_coach()
    {
        $data = $this->request->getPost(); // Use $this->request->getPost()
        $route = $this->routeModel->get_cr_info($data['cc_route_id']);
        if (empty($route)) {
            return redirect()->to(base_url('dashboard/coach'))->with('error', 'Invalid route ID.');
        }
        if ($route[0]['company_id'] != $this->com_id) {
            return redirect()->to(base_url('dashboard/coach'))->with('error', 'Unauthorized Action. This route does not belong to your company.');
        }
        if ($this->dashboardsModel->create_coach($data)) { // Use $this->dashboardsModel
            return redirect()->to(base_url('dashboard/coach/list')); // Redirect after successful creation
        } else {
            // Handle the error.  Important!  Flashdata, error messages, etc.
            $this->session->setFlashdata('error', 'Coach creation failed.');
            return redirect()->to(base_url('dashboard/coach')); // Redirect back to the form
        }
    }
}