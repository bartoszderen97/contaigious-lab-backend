<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExaminationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
            DB::table('examinations')->insert([
            'name' => string(15), (nazwa choroby/wirusa/bakterii)
            'pricePLN' => 30,  (cena bez groszy)
            'details' => ' antygen HBs; wynik w 24h;',  (' coś tam; dalej; tak jak nizej')
            'created_at' => now(),
            'updated_at' => now()
        ]);
         */

        DB::table('examinations')->insert([
            'name' => 'wirus HBV',
            'pricePLN' => 30,
            'details' => ' antygen HBs; wynik w 24h;',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
