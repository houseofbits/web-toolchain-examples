<?php

namespace App\Database\Seeds;

use DateTime;

class ProductTestSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $dateNow = (new DateTime('now'))->format('Y-m-d H:i:s');

        $data = [
            [
                'product_type' => 1,
                'name'    => 'Samsung',
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ],
            [
                'product_type' => 2,
                'name'    => 'Lenovo',
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ]
        ];

        // Using Query Builder
        $this->db->table('product')->insertBatch($data);
    }
}