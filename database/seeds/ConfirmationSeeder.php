<?php

use Illuminate\Database\Seeder;

class ConfirmationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Confirmation::class, 1000)->create();
    }
}
