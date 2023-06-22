<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Departments;

class Department extends Seeder
{
    public function run()
    {
        $model = new Departments;
        $faker = \Faker\Factory::create();
        $model->save([
            'name'=>'Information Technology',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Marketing',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Human Resource',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Accounting and Finance',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Engineering',
            'description' => $faker->sentence,
        ]);
    }
}
