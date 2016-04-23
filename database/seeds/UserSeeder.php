<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        factory(App\User::class, "admin")->create();
        //user
        factory(App\User::class, 50)->create();
    }
}
