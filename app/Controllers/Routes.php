<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Routes extends Controller
{
    protected $routeModel;
    protected $dashboardsModel;
    protected $session;

    public function __construct()
    {
        $this->routeModel = new \App\Models\Route();
        $this->dashboardsModel = new \App\Models\Dashboards();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data = [
            'title' => "Routes",
            'headline' => "Add Routes",
            'route_id' => $this->routeModel->get_route(),
        ];
        if ($this->session->get('com_id')) {
            $data['com_id'] = $this->session->get('com_id');
            $com = $this->dashboardsModel->get_c_info($data['com_id']);
            $data['company_name'] = $com['company_name'];
        }
        return view('dashboard/dash_header', $data)
            . view('dashboard/routes', $data)
            . view('dashboard/dash_footer');
    }

    public function list_route()
    {
        $data = [
            'title' => "Routes List",
            'headline' => "Manage Routes",
            'jsonResult' => $this->routeModel->list_routes(),
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/r_list', $data)
            . view('dashboard/dash_footer');
    }

    public function create_route()
    {
        if ($this->routeModel->cr_route($this->request->getPost())) {
            return redirect()->to(base_url('dashboard/routes'));
        } else {
            $data['error'] = "Route creation failed.";
            return view('dashboard/dash_header', $data)
                . view('dashboard/routes', $data)
                . view('dashboard/dash_footer');
        }
    }

    public function route_edit()
    {
        $id = $this->request->getPost('cid');
        $cl_msg = [];
        $company_info = $this->routeModel->get_r_info($id);
        foreach ($company_info as $cinfo) {
            $cl_msg['id'] = $cinfo['id'];
            $cl_msg['route_name'] = $cinfo['route_name'];
            $cl_msg['point_type'] = $cinfo['point_type'];
            $cl_msg['fare'] = $cinfo['fare'];
        }
        return $this->response->setJSON($cl_msg);
    }

    public function up_route()
    {
        $id = $this->request->getPost('re_id');
        $r_info = $this->routeModel->get_r_info($id);
        $data = ['id' => $id];

        foreach ($r_info as $r) {
            if ($r['route_name'] != $this->request->getPost('r_name')) {
                $data['field'] = 'route_name';
                $data['val'] = $this->request->getPost('r_name');
                $this->routeModel->up_r($data);
            }
            if ($r['fare'] != $this->request->getPost('r_fare')) {
                $data['field'] = 'fare';
                $data['val'] = $this->request->getPost('r_fare');
                $this->routeModel->up_r($data);
            }
            if ($r['point_type'] != $this->request->getPost('destination_type')) {
                $data['field'] = 'point_type';
                $data['val'] = $this->request->getPost('destination_type');
                $this->routeModel->up_r($data);
            }
        }
        return redirect()->to(base_url('dashboard/routes/lists'));
    }

    public function del_route()
    {
        $id = $this->request->getGet('id');
        if ($this->session->get('role_id') == '110') {
            $com_id = $this->session->get('com_id');
            $res = $this->routeModel->get_cr_info($id);
            if ($com_id != $res[0]['company_id']) {
                return view('errors/html/error_403', ['message' => 'You do not have permission to delete this route.']);
            }
        }
        $this->routeModel->del_route($id);
        return redirect()->to(base_url('dashboard/routes/lists'));
    }

    public function del_w_route()
    {
        $id = $this->request->getGet('id');
        $this->routeModel->del_w_route($id);
        return redirect()->to(base_url('dashboard/routes/lists'));
    }

    public function list_route2()
    {
        // http://localhost:8080/dashboard#
        $data = [
            'title' => "Routes List",
            'headline' => "Manage Routes",
            'routes' => $this->routeModel->list_routes3($this->session->get('com_id')),
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/r_list2', $data)
            . view('dashboard/dash_footer');
    }

    public function view_full_route()
    {
        $data = [
            'title' => "Routes List",
            'headline' => "Manage Routes",
            'results' => $this->routeModel->get_full_route($this->request->getGet('id')),
        ];
        if (($data['results'][0]['company_id'] != $this->session->get('com_id')) && $this->session->get('role_id') == '110') {
            return view('errors/html/error_403', ['message' => 'You do not have permission to access this route.']);
        }

        return view('dashboard/dash_header', $data)
            . view('dashboard/edit_routes', $data)
            . view('dashboard/dash_footer');
    }

    public function update_route()
    {
        $data = $this->request->getPost();
        $role_id = $this->session->get('role_id');
        $com_id = $this->session->get('com_id');
        if ($role_id == '110') {
            $rid = $data['route_id'][0];
            $res = $this->routeModel->get_cr_info($rid);
            if ($com_id != $res[0]['company_id']) {
                return view('errors/html/error_403', ['message' => 'You do not have permission to update this route.']);
            }
        }

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
                $this->routeModel->update_coach($up_data);
            }
            $this->routeModel->update_bulk_route($up_data);
        }
        return redirect()->to(base_url('dashboard/routes/lists'));
    }
}
