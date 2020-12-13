<?php

use App\Console\soSeeder;

class DatabaseSeeder extends soSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(SYSTableSeeder::class);
        $this->call(SYSMNUTableSeeder::class);
        $this->call(TBLUSRTableSeeder::class);
        $this->call(OTHERTableSeeder::class);
        // $this->call(TBLUAMTableSeeder::class);
        // $this->call(TBLDSCTBLSYSTableSeeder::class);
        
    }
}
