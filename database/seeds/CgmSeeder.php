<?php

use Illuminate\Database\Seeder;

class CgmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Seracademico\Entities\CGM::class, 100)->create();
    }
}
