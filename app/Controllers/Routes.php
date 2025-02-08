<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Routes extends Controller
{
    protected $routeModel;
    protected $session;

    public function __construct()
    {
        $this->routeModel = new \App\Models\Route(); // Instantiate the model
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = [
                'title' => "Routes",
                'headline' => "Add Routes",
                'route_id' => $this->routeModel->get_route(), // Use $this->routeModel
            ];

            return view('dashboard/dash_header', $data)
                . view('dashboard/routes', $data)
                . view('dashboard/dash_footer');
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function list_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = [
                'title' => "Routes List",
                'headline' => "Manage Routes",
                'jsonResult' => $this->routeModel->list_routes(), // Use $this->routeModel
            ];

            return view('dashboard/dash_header', $data)
                . view('dashboard/r_list', $data)
                . view('dashboard/dash_footer');
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function create_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            if ($this->routeModel->cr_route($this->request->getPost())) { // Use $this->routeModel and getPost()
                return redirect()->to(base_url('dashboard/routes'));
            }
            // Add error handling if cr_route fails.  Important!
            else {
                $data['error'] = "Route creation failed.";
                return view('dashboard/dash_header', $data)
                . view('dashboard/routes', $data)
                . view('dashboard/dash_footer');
            }
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function route_edit()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $id = $this->request->getPost('cid'); // Use $this->request->getPost()
            $cl_msg = [];
            $company_info = $this->routeModel->get_r_info($id); // Use $this->routeModel
            foreach ($company_info as $cinfo) {
                $cl_msg['id'] = $cinfo['id'];
                $cl_msg['route_name'] = $cinfo['route_name'];
                $cl_msg['point_type'] = $cinfo['point_type'];
                $cl_msg['fare'] = $cinfo['fare'];
            }
            return $this->response->setJSON($cl_msg); // Use $this->response->setJSON() for JSON responses
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function up_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $id = $this->request->getPost('re_id'); // Use $this->request->getPost()
            $r_info = $this->routeModel->get_r_info($id); // Use $this->routeModel
            $data = ['id' => $id];

            foreach ($r_info as $r) {
                if ($r['route_name'] != $this->request->getPost('r_name')) {
                    $data['field'] = 'route_name';
                    $data['val'] = $this->request->getPost('r_name');
                    $this->routeModel->up_r($data); // Use $this->routeModel
                }
                if ($r['fare'] != $this->request->getPost('r_fare')) {
                    $data['field'] = 'fare';
                    $data['val'] = $this->request->getPost('r_fare');
                    $this->routeModel->up_r($data); // Use $this->routeModel
                }
                if ($r['point_type'] != $this->request->getPost('destination_type')) {
                    $data['field'] = 'point_type';
                    $data['val'] = $this->request->getPost('destination_type');
                    $this->routeModel->up_r($data); // Use $this->routeModel
                }
            }
            return redirect()->to(base_url('dashboard/list_route2'));
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function del_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $id = $this->request->getGet('id'); // Use $this->request->getGet()
            $this->routeModel->del_route($id); // Use $this->routeModel
            return redirect()->to(base_url('dashboard/list_route2'));
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function del_w_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $id = $this->request->getGet('id'); // Use $this->request->getGet()
            $this->routeModel->del_w_route($id); // Use $this->routeModel
            return redirect()->to(base_url('dashboard/list_route2'));
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function list_route2()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = [
                'title' => "Routes List",
                'headline' => "Manage Routes",
                'routes' => $this->routeModel->list_routes2(), // Use $this->routeModel
            ];

            return view('dashboard/dash_header', $data)
                . view('dashboard/r_list2', $data)
                . view('dashboard/dash_footer');
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function view_full_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = [
                'title' => "Routes List",
                'headline' => "Manage Routes",
                'results' => $this->routeModel->get_full_route($this->request->getGet('id')), // Use $this->routeModel and getGet()
            ];

            return view('dashboard/dash_header', $data)
                . view('dashboard/edit_routes', $data)
                . view('dashboard/dash_footer');
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function update_route()
    {
        if ($this->session->get('username') && $this->session->get('role_id') === '111') {
            $data = $this->request->getPost();

            for ($i = 0; $i < count($data['id']); $i++) {
                $up_data = [
                    'id' => $data['id'][$i],
                    'route_id' => $data['route_id'][$i],
                    'route_name' => $data['route_name'][$i],
                    'or_id' => $data['or_id'][$i],
                    'fare' => $data['fare'][$i],
                    'point_type' => $data['destination_type'][$i],
                ];
                if ($up_data['point_type'] == 1 || $up_data['point_type'] == 0) {
                    $this->routeModel->update_coach($up_data); // Assuming this updates the coach table
                }
                $this->routeModel->update_bulk_route($up_data); // Updates the route table
            }
            return redirect()->to(base_url('dashboard/list_route2'));
        } else {
            return redirect()->to(base_url('admin'));
        }
    }
}