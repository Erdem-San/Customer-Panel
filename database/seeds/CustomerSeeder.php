<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mycustomers = ['Ahmet','John','Nakamura','Pelin','Carlos','Monica','Tiago'];
        foreach ($mycustomers as $mycustomer) {
          DB::table('customers')->insert([
            'name'=>$mycustomer,
            'comment'=>'The best day is the day you are happy..',
            'created_at'=>now(),
            'updated_at'=>now()
          ]);
    }
  }
}
