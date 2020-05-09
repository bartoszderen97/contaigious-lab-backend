<?php

use App\Models\User;
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
        $this->call(ExaminationSeeder::class);
        factory(User::class, 100)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
