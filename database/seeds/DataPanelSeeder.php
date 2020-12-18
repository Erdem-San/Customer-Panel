<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = ['Ahmet','John','Nakamura','Pelin','Carlos','Monica','Tiago'];
        foreach ($customers as $customer) {
          DB::table('datapanels')->insert([
            'name'=>$customer,
            'email'=>'customer@customer.com',
            'ip'=>'127.0.0.1',
            'prix'=>'100',
            'created_at'=>now(),
            'updated_at'=>now()
          ]);
    }
  }
}
