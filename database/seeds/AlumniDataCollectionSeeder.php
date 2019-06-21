<?php

use Illuminate\Database\Seeder;

class AlumniDataCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\AlumniDataCollection::class, 1000)->create();
    }
}
