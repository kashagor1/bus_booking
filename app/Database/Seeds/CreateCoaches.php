<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Districts;

class CreateCoaches extends Seeder
{
    private $districtsModel;

    public function run()
    {
        $this->districtsModel = new Districts(); // Initialize inside run() to avoid constructor issue

        $route_ids = $this->districtsModel->get_all_route_ids();

        foreach ($route_ids as $route_id) {
            $roi_data = $this->districtsModel->get_all_roi($route_id['route_id']);
            $roi_data = json_decode($roi_data, true);
            if ($roi_data['main_boarding'] == null) {
                continue;
            }

            // Generate bulk data for each route
            $numCoaches = 3;
            $routeid = $route_id['route_id'];

            for ($i = 0; $i < $numCoaches; $i++) {
                $totalSeatsOptions = [36, 40];
                $tseats = $totalSeatsOptions[array_rand($totalSeatsOptions)];
                $seat_column = 4;
                $seat_row = $tseats / $seat_column;

                $coachData = [
                    'route_id' => $routeid,
                    'main_boarding' => $roi_data['main_boarding'],
                    'final_destination' => $roi_data['final_destination'],
                    'total_fare' => $roi_data['total_fare'],
                    'company_id' => $roi_data['company_id'],
                    'coach_type' => 'NON-AC',
                    'vehicle_number' => $this->generateVehicleNumber(),
                    'supervisor_no' => $this->generateSupervisorNumber(),
                    'seat_layout' => $tseats,
                    'seat_row' => $seat_row,
                    'seat_column' => $seat_column,
                    'departure' => $this->generateRandomTime(),
                    'arrival' => $this->generateSecondRandomTime(),
                ];

                try {
                    $this->db->table('coach')->insert($coachData); // ✅ $this->db is now available
                } catch (\Exception $e) {
                    log_message('error', 'Error inserting coach: ' . $e->getMessage() . print_r($coachData, true));
                    continue;
                }
            }
        }
    }
    private function generateVehicleNumber(){
        $prefixes = ['DHAKA', 'CHATTOGRAM', 'SYLHET', 'RANGPUR', 'RAJSHAHI']; // Add more prefixes as needed
        $prefix = $prefixes[array_rand($prefixes)];
        $numbers = rand(10, 99); // Two-digit number
        $lprefix = ['KA', 'KHA','GA','GHA','UMA','TA','THA','DA','DHA','NA','PA','PHA','BA','BHA','MA','YA','RA','LA','VA','SHA','SA','HA'];
        $letters = $lprefix[array_rand($lprefix)];
        $digits = rand(1000, 9999); // Four-digit number

        return $prefix . ' ' . $letters . ' ' . $numbers . '-' . $digits;
    }

    private function generateSupervisorNumber()
    {
        $number = '01';
        for ($i = 1; $i < 10; $i++) {
            $number .= rand(0, 9);
        }
        return $number;
    }

    private function generateRandomTime() {
       return $this->getRandomTime('06:00', '10:00'); // Example: between 6 AM and 10 PM
    }
    private function generateSecondRandomTime() {
       return $this->getRandomTime('14:00', '22:00'); // Example: between 6 AM and 10 PM
    }
    private function getRandomTime(string $start, string $end)
    {
        $startTimestamp = strtotime($start);
        $endTimestamp = strtotime($end);

        if ($startTimestamp === false || $endTimestamp === false || $startTimestamp > $endTimestamp) {
            throw new \Exception("Invalid time range provided.");
        }

        $randomTimestamp = rand($startTimestamp, $endTimestamp);
        return date('H:i', $randomTimestamp);
    }
}