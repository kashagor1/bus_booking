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
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = [
                'title' => "Add Coach",
                'headline' => "Coaches",
            ];

            return view('dashboard/dash_header', $data)
                . view('dashboard/coach')
                . view('dashboard/dash_footer');
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function list_coach()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = [
                'title' => "Coach Lists",
                'headline' => "Manage Coaches",
                'result' => $this->dashboardsModel->coachlist(), // Use $this->dashboardsModel
            ];

            return view('dashboard/dash_header', $data)
                . view('dashboard/coachlist', $data)
                . view('dashboard/dash_footer');
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function view_coach_info()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
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
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function coach_info()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $id = $this->request->getGet('id'); // Use $this->request->getGet()
            $data = $this->coachModel->get_info($id); // Use $this->coachModel
            return $this->response->setJSON($data); // Return JSON response
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function update_coach()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = $this->request->getPost(); // Use $this->request->getPost()

            if ($this->coachModel->update_coach($data)) { // Use $this->coachModel
                return redirect()->to(base_url('dashboard/list_coach'));
            } else {
                // Handle the error.  Important!  Flashdata, error messages, etc.
                $this->session->setFlashdata('error', 'Coach update failed.');
                return redirect()->back(); // Redirect back to the form.
            }
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function delete_coach()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $id = $this->request->getGet('id'); // Use $this->request->getGet()

            if ($this->coachModel->delete_coach($id)) { // Use $this->coachModel
                return redirect()->to(base_url('dashboard/list_coach'));
            } else {
                 // Handle the error.  Important!  Flashdata, error messages, etc.
                $this->session->setFlashdata('error', 'Coach delete failed.');
                return redirect()->back(); // Redirect back to the list.
            }
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function create_coach()
    {
        if ($this->session->get('username')) {
            $data = $this->request->getPost(); // Use $this->request->getPost()
            if ($this->dashboardsModel->create_coach($data)) { // Use $this->dashboardsModel
                return redirect()->to(base_url('dashboard/list_coach')); // Redirect after successful creation
            } else {
                // Handle the error.  Important!  Flashdata, error messages, etc.
                $this->session->setFlashdata('error', 'Coach creation failed.');
                return redirect()->to(base_url('dashboard/coach')); // Redirect back to the form
            }
        } else {
            return redirect()->to(base_url('admin'));
        }
    }
}