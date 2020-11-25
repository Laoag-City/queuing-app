<?php

use Illuminate\Database\Seeder;

class QueueTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('queue_types')->insert([
            [
                'type' => 'Cedula, Violation, Fees, etc.',
                'color_regular' => 'blue',
                'color_pod' => 'orange',
                'queue_limit_regular' => 300,
                'queue_limit_pod' => 300
            ],
            [
                'type' => 'Business',
                'color_regular' => 'red',
                'color_pod' => 'green',
                'queue_limit_regular' => 300,
                'queue_limit_pod' => 300
            ],
            [
                'type' => 'Landtax',
                'color_regular' => 'green',
                'color_pod' => 'red',
                'queue_limit_regular' => 300,
                'queue_limit_pod' => 300
            ]
        ]);
    }
}
