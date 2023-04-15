<?php

use App\Repositories\Users\OwnerRepository;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repository = new OwnerRepository();
        $repository->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'Fpoly!=2021',
            'email' => 'admin@fpoly.vn',
            'type' => 'admin'
        ]);
    }
}
