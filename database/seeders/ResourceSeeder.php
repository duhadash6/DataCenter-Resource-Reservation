<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run()
    {
        $resources = [
            [
                'name' => 'Server-01',
                'type' => 'server',
                'status' => 'available',
                'location' => 'Rack 1 / DC A',
                'specs' => json_encode(['cpu' => 'Intel Xeon E5-2680', 'ram' => '256GB', 'storage' => '2TB SSD']),
            ],
            [
                'name' => 'Server-02',
                'type' => 'server',
                'status' => 'available',
                'location' => 'Rack 2 / DC A',
                'specs' => json_encode(['cpu' => 'Intel Xeon E5-2690', 'ram' => '512GB', 'storage' => '4TB SSD']),
            ],
            [
                'name' => 'VM-Cluster-01',
                'type' => 'vm',
                'status' => 'available',
                'location' => 'Host Server 1',
                'specs' => json_encode(['cpu' => '8 vCPU', 'ram' => '64GB', 'storage' => '500GB']),
            ],
            [
                'name' => 'VM-Cluster-02',
                'type' => 'vm',
                'status' => 'reserved',
                'location' => 'Host Server 3',
                'specs' => json_encode(['cpu' => '16 vCPU', 'ram' => '128GB', 'storage' => '1TB']),
            ],
            [
                'name' => 'Storage-Array-01',
                'type' => 'storage',
                'status' => 'available',
                'location' => 'Room 201',
                'specs' => json_encode(['type' => 'SAN', 'capacity' => '50TB', 'raid' => 'RAID 6']),
            ],
            [
                'name' => 'Storage-Array-02',
                'type' => 'storage',
                'status' => 'available',
                'location' => 'Room 202',
                'specs' => json_encode(['type' => 'NAS', 'capacity' => '100TB', 'raid' => 'RAID 10']),
            ],
            [
                'name' => 'Network-Switch-01',
                'type' => 'network',
                'status' => 'available',
                'location' => 'Floor 1',
                'specs' => json_encode(['ports' => '48 x 10GbE', 'bandwidth' => '1.9Tbps']),
            ],
            [
                'name' => 'Network-Switch-02',
                'type' => 'network',
                'status' => 'available',
                'location' => 'Floor 2',
                'specs' => json_encode(['ports' => '32 x 25GbE', 'bandwidth' => '3.2Tbps']),
            ],
            [
                'name' => 'Network-Switch-03',
                'type' => 'network',
                'status' => 'maintenance',
                'location' => 'Floor 2',
                'specs' => json_encode(['ports' => '48 x 10GbE', 'bandwidth' => '1.9Tbps']),
            ],
            [
                'name' => 'Server-Legacy-04',
                'type' => 'server',
                'status' => 'down',
                'location' => 'Rack 5 / DC B',
                'specs' => json_encode(['cpu' => 'Intel Xeon E5-1650', 'ram' => '128GB', 'storage' => '1TB']),
            ],
        ];

        foreach ($resources as $resource) {
            Resource::firstOrCreate(
                ['name' => $resource['name']],
                $resource
            );
        }
    }
}
