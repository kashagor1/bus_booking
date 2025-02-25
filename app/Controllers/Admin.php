<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $loginModel;
    protected $dashModel;
    protected $session;
    protected $validation; // Add validation property

    public function __construct()
    {
        $this->loginModel = new \App\Models\Login();
        $this->dashModel = new \App\Models\Dashboards();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation(); // Initialize validation service
    }

    public function index()
    {
        if (($this->session->get('role_id') == '111' || $this->session->get('role_id') == '110') && $this->session->get('username') != '') {
            $this->session->setFlashdata('success', 'Looged in Succcessfully');
            return redirect()->to(base_url('dashboard'));
        } else {

            return view('admin/login');
        }
    }

    public function login()
    {
        if (($this->session->get('role_id') == '111' || $this->session->get('role_id') == '110') && $this->session->get('username') != '') {
            $this->session->setFlashdata('success', 'Looged in Succcessfully');

            return redirect()->to(base_url('dashboard'));
        } else {
            $this->session->setFlashdata('error', 'Invalid Credentials!!!');

            return view('admin/login');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        $this->session->setFlashdata('success', 'Logged out successfully');

        return redirect()->to(base_url('admin'));
    }

    public function register()
    {
        $rs = $this->request->getPost();
        if ($rs) {
            $cr_res = $this->loginModel->register_user($rs); // Use $this->homModel
            if ($cr_res) {
                $this->session->set('username', $rs['username']);
                $this->session->set('role_id', $rs['role_id']);
                $this->session->setFlashdata('success', 'Logged in successfully');

                return redirect()->to(BASE_URL('dashboard')); // Redirect to fillinfo after successful registration
            } else {
                $data['error'] = "Registration failed. Please try again.";
                $this->session->setFlashdata('error', 'Registration failed. Please try again.');

                return view('admin/register', $data);
            }
        } else {
            $data['error'] = "Registration failed. Please try again.";
            return view('admin/register', $data);
        }
    }

    // public function auth()
    // {
    //     $this->check_input(); // Call validation function
    //     if ($this->validation->run() == true) { // Check validation result
    //         echo "die";die;

    //         $data = $this->getData();
    //         $auth_res = $this->loginModel->checkUser($data); // Use $this->loginModel

    //         if ($auth_res) {  // Check if $auth_res is valid (not null or false)
    //             $session_data = [
    //                 'username' => $auth_res->username,
    //                 'role_id' => $auth_res->role_id,
    //             ];
    //             var_dump($auth_res);die;
    //             $this->session->set($session_data); // Use $this->session->set()
    //             $this->session->set('role_id', '111');

    //             return redirect()->to(base_url('dashboard'));
    //         } else {
    //             // Authentication failed (wrong credentials)
    //             $this->session->setFlashdata('error', 'Opps! Wrong Credentials!'); // Use flashdata for error message
    //             return redirect()->to(base_url('admin'));
    //         }
    //     } else {
    //         // Validation failed
    //         $this->session->setFlashdata('errors', $this->validation->getErrors()); // Store validation errors in session
    //         return redirect()->to(base_url('admin')); // Redirect back to login form to show errors
    //     }
    // }

    public function getData()
    {
        return [
            'user_name' => $this->request->getPost('user_name'), // Use $this->request->getPost()
            'password' => $this->request->getPost('password'),
        ];
    }

    // public function check_input()
    // {
    //     // Use CodeIgniter 4's validation rules
    //     $this->validation->setRules([
    //         'user_name' => 'required',
    //         'password' => 'required',
    //     ]);

    // }
    public function auth()
    {
        // Validate input fields
        if (
            !$this->validate([
                'user_name' => 'required|trim',
                'password' => 'required|trim'
            ])
        ) {
            return redirect()->to('/admin')->with('error', 'Oops! Wrong Credentials!');
        }

        $data = [
            'user_name' => $this->request->getPost('user_name'),
            'password' => $this->request->getPost('password')
        ];

        $auth_res = $this->loginModel->checkUser($data);

        if ($auth_res) {
            $session_data = [
                'username' => $auth_res->username,
                'role_id' => $auth_res->role_id,
                'logged_in' => true
            ];
            if ($auth_res->role_id == '110') {
                $com = $this->dashModel->get_com_id($auth_res->id);
                $session_data['com_id'] = $com->company_id;
            }
            $this->session->set($session_data);
            $this->session->setFlashdata('success', 'Logged in successfully');

            return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/admin')->with('error', 'Oops! Wrong Credentials!');
        }
    }
}