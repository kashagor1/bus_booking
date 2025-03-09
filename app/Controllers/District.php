<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class District extends Controller
{
    protected $districtsModel;

    public function __construct()
    {
        $this->districtsModel = new \App\Models\Districts(); // Instantiate the model

    }


    public function index()
    {
        $districts = $this->districtsModel->getList(); // Assuming getList()  returns an array
    
        return $this->response->setJSON($districts); // Use setJSON for correct JSON response
    }
    public function route_info()
    {
        $ni = $this->request->getPost('id'); // Use $this->request->getPost()
        

        $roi_data = $this->districtsModel->get_all_roi($ni); // Store the returned data
        return $this->response->setJSON($roi_data); // Use setJSON for correct JSON response
    }
    public function route_ids()
    {
        $route_ids = $this->districtsModel->get_all_route_ids(); // Assuming get_all_route_ids() returns an array
        return $this->response->setJSON($route_ids); // Use setJSON for correct JSON response
    }
}