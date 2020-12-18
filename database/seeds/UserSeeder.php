<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('users')->insert([
            'email'=>'customer@customer.com',
            'password'=>bcrypt(123),
            'created_at'=>now(),
            'updated_at'=>now()
          ]);
    }
}
