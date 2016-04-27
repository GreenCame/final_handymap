<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            ['picture' => 'bus.png'],
            ['picture' => 'construct.png'],
            ['picture' => 'deadend.png'],
            ['picture' => 'dog.png'],
            ['picture' => 'down.png'],
            ['picture' => 'drunk.png'],
            ['picture' => 'elevator.png'],
            ['picture' => 'fire.png'],
            ['picture' => 'help.png'],
            ['picture' => 'hospital.png'],
            ['picture' => 'narrow.png'],
            ['picture' => 'parking.png'],
            ['picture' => 'police.png'],
            ['picture' => 'rock.png'],
            ['picture' => 'shit.png'],
            ['picture' => 'slippery.png'],
            ['picture' => 'stair.png'],
            ['picture' => 'up.png']
        ]);
    }
}
