<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(PointSeeder::class);
        $this->call(ConfirmationSeeder::class);
    }

}
