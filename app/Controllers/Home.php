<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    protected $homModel;
    protected $seatsModel;
    protected $routeModel;
    protected $session;

    public function __construct()
    {
        $this->homModel = new \App\Models\Hom(); // Instantiate the model
        $this->seatsModel = new \App\Models\Seats();
        $this->routeModel = new \App\Models\Route();
        $this->session = \Config\Services::session(); // Get the session service
    }

    public function index()
    {
        $isLoggedin = $this->session->get('username') ? true : false; // CI4 way to check session
        $data['title'] = "Home Page";
        $data = ['isLoggedin' => $isLoggedin];
        $data['role_id'] = $this->session->get('role_id');
        $this->session->remove('booking_data');
        return view('home/header', $data) // Use return view() in CI4
            . view('home/home')
            . view('home/footer');
    }

    public function newsearch(){

        return view('home/search_demo');
    }


   
    public function search()
    {
        $this->session->remove('booking_data');

        $isLoggedin = $this->session->get('username') ? true : false;
        $in = $this->request->getGet(); // Use $this->request->getGet() for GET requests

        $data = [];
        $currentDate = date('Y-m-d');
        $inputDate = $in['date'];
        $next7Days = date('Y-m-d', strtotime('+7 days'));
        
        $data['result'] = ($inputDate >= $currentDate && $inputDate <= $next7Days) ?
            $this->homModel->get_bus($in) : null; // Use $this->homModel
        $companies = [];
        $coach_types = [];
        foreach ($data['result'] as $trip) {
            $companies[] = $trip['company_name'];
            $coach_types[] = $trip['coach_type'];
        }
        $data['companies'] = array_unique($companies);
        $data['coach_types'] = array_unique($coach_types);
        // var_dump($data['companies']);die;

        $data['or'] = $in['origin'];
        $data['ds'] = $in['destination'];
        $data['dt'] = $in['date'];
        $data['isLoggedin'] = $isLoggedin;
        $data['role_id'] = $this->session->get('role_id');

        return view('home/header', $data)
            . view('home/search', $data)
            . view('home/footer');
    }
  public function get_seat_map() {
    // Dummy seat map data (for testing only - replace with your actual data)
    $seat_map = [
        [
            ["seat_number" => "1A", "available" => true],
            ["seat_number" => "1B", "available" => false],
            ["seat_number" => "1C", "available" => true],
            ["seat_number" => "1D", "available" => true],
            ["seat_number" => "1E", "available" => false]
        ],
        [
            ["seat_number" => "2A", "available" => true],
            ["seat_number" => "2B", "available" => true],
            ["seat_number" => "2C", "available" => false],
            ["seat_number" => "2D", "available" => true],
            ["seat_number" => "2E", "available" => true]
        ],
        [
            ["seat_number" => "3A", "available" => true],
            ["seat_number" => "3B", "available" => false],
            ["seat_number" => "3C", "available" => true],
            ["seat_number" => "3D", "available" => true],
            ["seat_number" => "3E", "available" => false]
        ],
        [
            ["seat_number" => "4A", "available" => true],
            ["seat_number" => "4B", "available" => true],
            ["seat_number" => "4C", "available" => false],
            ["seat_number" => "4D", "available" => true],
            ["seat_number" => "4E", "available" => true]
        ]
    ];

    echo json_encode(['status' => 'success', 'seat_map' => $seat_map]);
}
    // public function seatselection()
    // {
    //     // $indata = json_decode($this->request->getPost('params'), true); // Use $this->request->getPost()
    //     $this->session->remove('booking_data'); // CI4 session unset
    //     $trip_id = $this->request->getPost('trip_id');
    //     $route_id = $this->request->getPost('route_id');
    //     $coach_id = $this->request->getPost('coach_id');
    //     $isLoggedin = $this->session->get('username') ? true : false;

    //     // $data['origin'] = base64_decode($indata['origin']);
    //     // $data['destination'] = base64_decode($indata['destination']);
    //     // $data['fare'] = $indata['fare'];
    //     // $data['trip_id'] = $indata['trip_id'];
    //     // $data['coach_id'] = $indata['coach_id'];
    //     // $data['route_id'] = $indata['route_id'];
    //     // $data['date'] = $indata['date'];
    //     // $data['isLoggedin'] = $isLoggedin;
    //     // $data['role_id'] = $this->session->get('role_id');

    //     $data['results'] = $this->seatsModel->booked_seats($trip_id); // Use $this->seatsModel
    //     $data['froute'] = $this->routeModel->get_full_route($route_id); // Use $this->routeModel
    //     $data['info'] = $this->seatsModel->get_all_info($coach_id)[0];
    //     return $this->response->setJSON([
    //         'status' => true,  // Indicate success
    //         'data' => $data,
    //     ]);
    //     // return view('home/header', $data)
    //     //     . view('seatsl/viewseats', $data)
    //     //     . view('seatsl/seats', $data)
    //     //     . view('seatsl/footer');
    // }

    public function seatselection()
{
    $trip_id = $this->request->getPost('trip_id');
    $route_id = $this->request->getPost('route_id');
    $coach_id = $this->request->getPost('coach_id');

    if ($trip_id === null || $route_id === null || $coach_id === null) {
        return $this->response->setJSON(['status' => false, 'message' => 'Missing required parameters']);
    }

    // ... use $trip_id, $route_id, and $coach_id ...

    $data['results'] = $this->seatsModel->booked_seats($trip_id);
    $data['froute'] = $this->routeModel->get_full_route($route_id);
    $data['info'] = $this->seatsModel->get_all_info($coach_id)[0];
         return $this->response->setJSON([
            'status' => true,  // Indicate success
            'data' => $data,
        ]);

    // ... rest of your code ...
}
    public function login() {
      
        if (!$this->session->get('username')) {
            // Retrieve all form data properly
            $rs = $this->request->getPost(); 
            
            $data = ['isLoggedin' => false];
    
            // Load views
            $view = view('home/header', $data) . view('home/lorform') . view('home/footer');
    
            if ($rs && isset($rs['loginUsername'], $rs['loginPassword'])) {
                // Encrypt the password
                // $rs['loginPassword'] = md5($rs['loginPassword']);
    
                // Ensure the model is loaded before using it
                $udata = $this->homModel->slogin($rs); // Use $this->homModel
                if ($udata!=FALSE) { 
                    $this->session->set('username', $udata->username);
                    $this->session->set('role_id', $udata->role_id);
                    $this->session->setFlashdata('success', 'Logged in successfully');
                    $this->session->get('goto') ? $view = redirect()->to(base_url($this->session->get('goto'))) : $view = redirect()->to(base_url());
                    $this->session->remove('goto');
                    return $view; // Use base_url()
                } else {
                    return redirect()->to(base_url('login')); 
                }
            }
    
            return $view;
        } elseif ($this->session->get('role_id') == '111' && $this->session->get('username')) {
            $this->session->setFlashdata('success', 'Logged in as admin');
            return redirect()->to(base_url('profile'));
        } else {
            return redirect()->to(base_url());
        }
    }
    

    public function logout()
    {
        $this->session->destroy();
        $this->session->setFlashdata('error', 'Logged out sucessfully');

        return redirect()->to(BASE_URL());
    }

    public function midform()
    {
        $isLoggedin = $this->session->get('username') ? true : false;
        $role_id = $this->session->get('role_id');
        $oata['role_id'] = $this->session->get('role_id');
        $oata['isLoggedin'] = $this->session->get('username') ? true : false;
        $data = $this->request->getPost();
        $selectedSeats = json_decode($data['selected_seats'], true);

        if (!$this->session->has('booking_data')) { // Use $this->session->has()
            $ata = [
                'selected_seats' => $selectedSeats,
                'coach_id' => $data['coach_id'],
                'trip_id' => $data['trip_id'],
                'route_id' => $data['route_id'],
                'fare' => $data['fare'],
                'origin' => base64_decode($data['origin']),
                'destination' => base64_decode($data['destination']),
                'date' => $data['date']
            ];
            $this->session->set('booking_data', $ata);
        }
        if ($isLoggedin === true) {
            return redirect()->to(BASE_URL('fillinfo'));
        } else {
            $this->session->set('goto', 'fillinfo');
            return view('home/header', $oata)
                . view('home/lorform')
                . view('home/footer');
        }
    }

    public function payment()
    {
       
        $data['isLoggedin'] = $this->session->get('username') ? true : false;
        $data['role_id'] = $this->session->get('role_id');
        $dat = $this->request->getPost();
        $this->session->set('personal_info', $dat);

        return view('home/header', $data)
            . view('seatsl/step2')
            . view('seatsl/footer');
    }

    public function process_payment()
    {
        $post = $this->session->get(); // Use $this->session->get()

        if ($this->homModel->process_payment($post)) { // Use $this->homModel
            return redirect()->to(BASE_URL('tickets'));
        } else {
            return redirect()->to(BASE_URL());
        }
    }

    public function fillinfo()
    {
        $isLoggedin = $this->session->get('username') ? true : false;
       
        $data['isLoggedin'] = $this->session->get('username') ? true : false;
        $data['role_id'] = $this->session->get('role_id');

        $bookingData = $this->session->get('booking_data');
        if(!$bookingData) {
            return redirect()->to(BASE_URL());
        }
        // $bookingData['selected_seats'] = json_decode($bookingData['selected_seats'], true); 
        // var_dump($bookingData);die;

        return view('home/header', $data)
            . view('seatsl/step1', $bookingData)
            . view('seatsl/footer');
    }

    //Special Login For Midform but not needed now as we have a general login function
    // public function slogin()
    // {
    //     $rs = $this->request->getPost();
    //     $rs['loginPassword'] = md5($rs['loginPassword']);

    //     if ($this->homModel->slogin($rs)) { // Use $this->homModel
    //         $this->session->set('username', $rs['loginUsername']);
    //         return redirect()->to(BASE_URL('fillinfo'));
    //     } else {
    //         return redirect()->to(BASE_URL('midform'));
    //     }
    // }


    public function newreg()
    {
        $rs = $this->request->getPost();
        $cr_res = $this->homModel->register_user($rs); // Use $this->homModel

        if ($cr_res) {
            $this->session->set('username', $rs['email']);
            $this->session->get('goto') ? $view = redirect()->to(base_url($this->session->get('goto'))) : $view = redirect()->to(base_url());
            $this->session->remove('goto');
            return $view;
        } else {
            return redirect()->to(BASE_URL('login'));
        }
    }
    //Special registration function for midform but not needed now as we have a general registration function
    // public function register(){
    //         $rs = $this->request->getPost();
    //         if ($rs) {
    //             $cr_res = $this->homModel->register_user($rs); // Use $this->homModel
    //             if ($cr_res) {
    //                 $this->session->set('username', $rs['email']);
    //                 return redirect()->to(BASE_URL('fillinfo')); // Redirect to fillinfo after successful registration
    //             } else {
    //                 // Handle registration failure.  Important!
    //                 $data['error'] = "Registration failed. Please try again."; // Example error message
    //                 return view('home/header', $data) . view('home/lorform', $data) . view('home/footer'); // Show error on registration form
    //                 // Or redirect back to the registration form with a flash message:
    //                 // $this->session->setFlashdata('error', 'Registration failed. Please try again.');
    //                 // return redirect()->to(BASE_URL('register')); // Assuming 'register' is your registration form route
    //             }
    //         } else {
    //           // Handle the case where no POST data was submitted.
    //           //  This might be the initial page load of the registration form.
    //           $data['isLoggedin'] = $this->session->get('username') ? true : false;
    //           $data['role_id'] = $this->session->get('role_id');
    //           return view('home/header', $data) . view('home/lorform', $data) . view('home/footer'); // Display the registration form
    //         }
    //     }
    
}