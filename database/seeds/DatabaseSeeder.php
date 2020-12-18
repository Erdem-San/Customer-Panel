<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DataPanelSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(IpListSeeder::class);
        $this->call(UserSeeder::class);
    }
}
