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
        // $this->call(UsersTableSeeder::class);

        $howMany=100;

        factory(\App\User::class, 7)->create();
        for ($i=0; $i<=$howMany; $i++) {
            factory(\App\Message::class)->create();
        }
    }
}
