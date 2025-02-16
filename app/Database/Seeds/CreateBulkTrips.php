<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Trips;
use App\Models\Coaach;

class CreateBulkTrips extends Seeder
{
    private $tripsModel;
    private $coachModel;

    public function run()
    {
        $this->tripsModel = new Trips(); // Initialize inside run() to avoid constructor issue
        $this->coachModel = new Coaach(); // Initialize inside run() to avoid constructor issue
        $coaches = $this->coachModel->get_all_coach_id(); // Get all coaches

        $today = strtotime(date('Y-m-d')); // Get today's timestamp

        foreach ($coaches as $coach) {
            for ($i = 0; $i < 30; $i++) { // Loop for the next 30 days
                $departureDate = date('Y-m-d', strtotime("+$i days", $today)); // Generate date

                $data = [
                    'coach_id' => $coach['coach_id'],
                    'departure_date' => $departureDate,
                    'trip_status' => 1 // Assuming 1 means active
                ];

                try {
                    $this->create_trip($data); // Create a trip
                } catch (\Exception $e) {
                    log_message('error', 'Error inserting trip: ' . $e->getMessage() . print_r($data, true));
                    continue;
                }
            }
        }
    }
    private function create_trip($data)
    {
        $qq = "INSERT INTO trips (`coach_id`, `departure_date`, `trip_status`) VALUES (?, ?, ?)";
        
        return $this->db->query($qq, [$data['coach_id'], $data['departure_date'], 1]);
    }

}
