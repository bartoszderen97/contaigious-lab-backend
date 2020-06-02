<?php

use App\Models\ApplicationForExamination;
use App\Models\ExaminationResult;
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
        factory(ApplicationForExamination::class, 250)->create();
        factory(ExaminationResult::class, 250)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
