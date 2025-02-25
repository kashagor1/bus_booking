<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $dashboardsModel;
    protected $hom;
    protected $personModel;

    protected $ticketModel;
    protected $session;


    public function __construct()
    {
        $this->dashboardsModel = new \App\Models\Dashboards(); // Instantiate the model
        $this->personModel = new \App\Models\Person();
        $this->ticketModel = new \App\Models\TicketModel();
        $this->hom = new \App\Models\Hom();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $ticket_count = $this->ticketModel->count_tickets(date('Y-m-d'));
        $bus_count = $this->dashboardsModel->count_trips(date('Y-m-d'));
        $com_count = $this->dashboardsModel->count_companies();
        $user_count = $this->dashboardsModel->count_users();
        $data = [
            'title' => "Dashboard",
            'headline' => "Dashboard",
            'ticket_count' => $ticket_count,
            'bus_count' => $bus_count,
            'com_count' => $com_count,
            'user_count' => $user_count,
        ];
        return view('dashboard/dash_header')
            . view('dashboard/index', $data)
            . view('dashboard/dash_footer');
        // if ($this->session->get('username') && $this->session->get('role_id') === '111') {

        // } else {
        //     return redirect()->to(base_url('admin'));
        // }
    }
    public function purchased_tickets($date = null)
    {

        if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return "Invalid date format. Please use YYYY-MM-DD.";
        }

        $tickets = $this->ticketModel->get_tickets($date);
        // var_dump($tickets);die;
        return view('dashboard/dash_header')
            . view('dashboard/purchased_tickets', ['tickets' => $tickets])
            . view('dashboard/dash_footer');
    }

    public function sendref()
    {
        $pnr = $this->request->getGet('pnr'); // Use $this->request->getGet()
        $this->personModel->make_refund($pnr); // Use $this->personModel
        return redirect()->to(base_url('dashboard/ticket/refund'));
    }

    public function ticket()
    {
        return view('dashboard/dash_header')
            . view('dashboard/ticket')
            . view('dashboard/dash_footer');
    }

    public function refund()
    {
        $data = ['refunds' => $this->personModel->get_all_refundlist()]; // Use $this->personModel
        return view('dashboard/dash_header')
            . view('dashboard/refund', $data)
            . view('dashboard/dash_footer');
    }

    public function company()
    {
        if ($this->request->getPost()) { // Use $this->request->getPost()
            $this->dashboardsModel->create_company($this->request->getPost());  // Use $this->dashboardsModel
        }
        $listcmp = $this->dashboardsModel->list_company();

        $data = [
            'title' => "Company",
            'headline' => "Manage Company",
            'jsonResult' => $listcmp, // Use $this->dashboardsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/company')
            . view('dashboard/c_list', $data)
            . view('dashboard/dash_footer');
    }

    public function company_edit()
    {
        $id = $this->request->getGet('cid'); // Use $this->request->getPost()
        $cl_msg = [];
        $company_info = $this->dashboardsModel->get_c_info($id); // Use $this->dashboardsModel
        $cl_msg['id'] = $company_info['company_id'];
        $cl_msg['company_name'] = $company_info['company_name'];
        $cl_msg['company_phone'] = $company_info['company_phone'];
        $cl_msg['company_address'] = $company_info['company_address'];

        return $this->response->setJSON($cl_msg); // Return JSON response
    }

    public function update_company()
    {
        if ($this->request->getPost()) { // Use $this->request->getPost()
            $com_id = $this->request->getPost('company_id'); // Use $this->request->getPost()
            $up_msg = $this->dashboardsModel->update_c_info($com_id, $this->request->getPost()); // Use $this->dashboardsModel
            if ($up_msg === 'Success') {
                return redirect()->to(base_url('dashboard/company'));
            } else {
                // Handle the error appropriately.
                $this->session->setFlashdata('error', $up_msg); // Example using flashdata
                return redirect()->to(base_url('dashboard/company')); // Or redirect back to the edit form
            }
        }
    }

    public function company_info()
    {
        $id = $this->request->getGet('cid'); // Use $this->request->getGet()
        $company_info = $this->dashboardsModel->get_c_info($id); // Use $this->dashboardsModel
        return $this->response->setJSON($company_info); // Return JSON response
    }

    public function delete_company()
    {
        $this->dashboardsModel->delete_company($this->request->getGet('id')); // Use $this->dashboardsModel and getGet()
        return redirect()->to(base_url('dashboard/company'));
    }
    public function cusers($id)
    {
        if ($this->request->getPost()) { // Use $this->request->getPost()

            $data = $this->request->getPost();
            $res = $this->hom->register_user($data);
            $data['company_id'] = $id;
            $data['user_id'] = $res;
            $ress = $this->dashboardsModel->create_company_user($data);
            if ($res && $ress) {
                return redirect()->to(base_url('dashboard/company/users/' . $id));
            }
        }
        $listcmp = $this->dashboardsModel->get_cusers($id);

        $data = [
            'title' => "Company",
            'headline' => "Manage Company",
            'jsonResult' => $listcmp, // Use $this->dashboardsModel
        ];

        return view('dashboard/dash_header', $data)
            . view('dashboard/company_users')
            . view('dashboard/company_users_list', $data)
            . view('dashboard/dash_footer');

    }

    public function user_info()
    {
        $id = $this->request->getPost('uid'); // Use $this->request->getPost()
        $company_info = $this->dashboardsModel->get_cuser_info($id); // Use $this->dashboardsModel
        return $this->response->setJSON($company_info); // Return JSON response
    }
    public function update_user()
    {
        $postData = $this->request->getPost();
        $id = $postData['uid'];

        $res = $this->dashboardsModel->update_c_user($id, $postData);
        $ci = $this->dashboardsModel->get_com_id($id);
        $cid = $ci->company_id;
        if ($res) {

            return redirect()->to(base_url('dashboard/company/users/' . $cid));
        } else {
            return redirect()->to(base_url('dashboard/company/users/' . $cid));
        }
    }
}