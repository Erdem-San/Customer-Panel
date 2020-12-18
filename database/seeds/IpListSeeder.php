<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IpListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $iplists = ['127.0.0.1','127.0.0.1','127.0.0.1','127.0.0.1','127.0.0.1'];
        foreach ($iplists as $iplist) {
          DB::table('iplists')->insert([
            'ip'=>$iplist,
            'status'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
          ]);
        }
    }
}
