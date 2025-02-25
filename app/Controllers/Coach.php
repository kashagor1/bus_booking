<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Coach extends Controller
{
    protected $dashboardsModel;
    protected $coachModel; // Renamed for clarity
    protected $session;

    public function __construct()
    {
        $this->dashboardsModel = new \App\Models\Dashboards();
        $this->coachModel = new \App\Models\Coaach(); // Use correct model name and namespace
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $role_id = $this->session->get();
        var_dump($role_id);
        die;
        $data = [
            'title' => "Add Coach",
            'headline' => "Coaches",
        ];
        return view('dashboard/dash_header', $data) . view('dashboard/coach') . view('dashboard/dash_footer');

    }

    public function list_coach()
    {
        $data = [
            'title' => "Coach Lists",
            'headline' => "Manage Coaches",
            'result' => $this->dashboardsModel->coachlist(), // Use $this->dashboardsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/coachlist', $data)
            . view('dashboard/dash_footer');
    }

    public function view_coach_info()
    {
        $id = $this->request->getGet('id'); // Use $this->request->getGet()
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
        $data = $this->request->getPost(); // Use $this->request->getPost()
        if ($this->coachModel->update_coach($data)) { // Use $this->coachModel
            return redirect()->to(base_url('dashboard/coach/list'));
        } else {
            $this->session->setFlashdata('error', 'Coach update failed.');
            return redirect()->back(); // Redirect back to the form.
        }
    }

    public function delete_coach()
    {
        $id = $this->request->getGet('id'); // Use $this->request->getGet()
        if ($this->coachModel->delete_coach($id)) { // Use $this->coachModel
            return redirect()->to(base_url('dashboard/coach/list'));
        } else {
            $this->session->setFlashdata('error', 'Coach delete failed.');
            return redirect()->back(); // Redirect back to the list.
        }
    }

    public function create_coach()
    {
        $data = $this->request->getPost(); // Use $this->request->getPost()
        if ($this->dashboardsModel->create_coach($data)) { // Use $this->dashboardsModel
            return redirect()->to(base_url('dashboard/coach/list')); // Redirect after successful creation
        } else {
            // Handle the error.  Important!  Flashdata, error messages, etc.
            $this->session->setFlashdata('error', 'Coach creation failed.');
            return redirect()->to(base_url('dashboard/coach')); // Redirect back to the form
        }
    }
}