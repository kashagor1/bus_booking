<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['district_name' => 'Dhaka'],
            ['district_name' => 'Faridpur'],
            ['district_name' => 'Gazipur'],
            ['district_name' => 'Gopalganj'],
            ['district_name' => 'Kishoreganj'],
            ['district_name' => 'Madaripur'],
            ['district_name' => 'Manikganj'],
            ['district_name' => 'Munshiganj'],
            ['district_name' => 'Narayanganj'],
            ['district_name' => 'Narsingdi'],
            ['district_name' => 'Rajbari'],
            ['district_name' => 'Shariatpur'],
            ['district_name' => 'Tangail'],
            ['district_name' => 'Bogra'],
            ['district_name' => 'Joypurhat'],
            ['district_name' => 'Naogaon'],
            ['district_name' => 'Natore'],
            ['district_name' => 'Chapainawabganj'],
            ['district_name' => 'Pabna'],
            ['district_name' => 'Rajshahi'],
            ['district_name' => 'Sirajganj'],
            ['district_name' => 'Dinajpur'],
            ['district_name' => 'Gaibandha'],
            ['district_name' => 'Kurigram'],
            ['district_name' => 'Lalmonirhat'],
            ['district_name' => 'Nilphamari'],
            ['district_name' => 'Panchagarh'],
            ['district_name' => 'Rangpur'],
            ['district_name' => 'Thakurgaon'],
            ['district_name' => 'Barguna'],
            ['district_name' => 'Barisal'],
            ['district_name' => 'Bhola'],
            ['district_name' => 'Jhalokathi'],
            ['district_name' => 'Patuakhali'],
            ['district_name' => 'Pirojpur'],
            ['district_name' => 'Bandarban'],
            ['district_name' => 'Brahmanbaria'],
            ['district_name' => 'Chandpur'],
            ['district_name' => 'Chattogram'],
            ['district_name' => 'Cox\'s Bazar'],
            ['district_name' => 'Cumilla'],
            ['district_name' => 'Feni'],
            ['district_name' => 'Khagrachhari'],
            ['district_name' => 'Lakshmipur'],
            ['district_name' => 'Noakhali'],
            ['district_name' => 'Rangamati'],
            ['district_name' => 'Habiganj'],
            ['district_name' => 'Moulvibazar'],
            ['district_name' => 'Sunamganj'],
            ['district_name' => 'Sylhet'],
            ['district_name' => 'Bagerhat'],
            ['district_name' => 'Chuadanga'],
            ['district_name' => 'Jashore'],
            ['district_name' => 'Jhenaidah'],
            ['district_name' => 'Khulna'],
            ['district_name' => 'Kushtia'],
            ['district_name' => 'Magura'],
            ['district_name' => 'Meherpur'],
            ['district_name' => 'Narail'],
            ['district_name' => 'Satkhira'],
            ['district_name' => 'Jamalpur'],
            ['district_name' => 'Mymensingh'],
            ['district_name' => 'Netrokona'],
            ['district_name' => 'Sherpur'],
        ];

        $this->db->table('district')->insertBatch($data);
    }
}
