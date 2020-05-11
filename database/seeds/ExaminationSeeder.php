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
            ]): DB::table('examinations')->insert([
            'name' => string(15), (nazwa choroby/wirusa/bakterii)
            'pricePLN' => 30,  (cena bez groszy)
            'details' => ' antygen HBs; wynik w 24h',  (' coś tam; dalej; tak jak nizej')
            'created_at' => now(),
            'updated_at' => now() ]);
        ]);
         */

        DB::table('examinations')->insert([
            'name' => 'wirus HBV',
            'pricePLN' => 30,
            'details' => 'antygen HBs; wynik w 24h',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('examinations')->insert([
            'name' => 'COVID-19',
            'pricePLN' => 300,
            'details' => 'Przeciwciała IgG, IgM;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'WZW typu B-przeciwciała anty-HBs',
            'pricePLN' => 35,
            'details' => 'Przeciwciała anty HBs;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'WZW typu B- przeciwciała anty-HBc IgM',
            'pricePLN' => 30,
            'details' => 'Przeciwciała anty HBc klasy IgM;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'WZW typu B - przeciwciała anty-HBc',
            'pricePLN' => 30,
            'details' => 'Przeciwciała anty HBc LW AHBCIG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Wirus HCV',
            'pricePLN' => 30,
            'details' => 'Przeciwciała anty HCV LW AHCV;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Wirus HIV - przeciwciała anty-HIV1/HIV2 i antygen p24 ',
            'pricePLN' => 30,
            'details' => 'Przeciwciała anty-HIV1/HIV2 i antygen p24 LW HIV;wynik po ok.5 dniach',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Wirus HIV',
            'pricePLN' => 245,
            'details' => 'LW HIV POTW;wynik po 7 dniach',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'WZW typu B - antygen Hbe',
            'pricePLN' => 30,
            'details' => 'Antygen Hbe LW HBE AG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Test na antygen HBs',
            'pricePLN' => 70,
            'details' => 'Przeciwciała HbsAg LW TPOTW;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Toksoplazmoza antygeny IgM',
            'pricePLN' => 33,
            'details' => 'Przeciwciała LW TOX IgM;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Toksoplazmoza antygeny IgG',
            'pricePLN' => 29,
            'details' => 'Przeciwciała LW TOX IgG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Toksomoplazmoza - poziom IgG',
            'pricePLN' => 30,
            'details' => 'Przeciwciała IgG LW TOX AWI;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Różyczka przeciwciała IgM',
            'pricePLN' => 46,
            'details' => 'Przeciwciała LW RUB IgM;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Różyczka przeciwciała IgG',
            'pricePLN' => 29,
            'details' => 'Przeciwciała LW RUB IgG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Cytomegalia przeciwciała IgM',
            'pricePLN' => 40,
            'details' => 'Przeciwciała LW CMV IgM;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Cytomegalia przeciwciała IgG',
            'pricePLN' => 30,
            'details' => 'Przeciwciała LW CMV IgG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Cytomegalia - poziom IgG',
            'pricePLN' => 42,
            'details' => 'Przeciwciała IgG LW CMVAWI;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Bolerioza przeciwciała IgM',
            'pricePLN' => 25,
            'details' => 'Przeciwciała LW LYME IgM;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Bolerioza przeciwciała IgG',
            'pricePLN' => 25,
            'details' => 'Przeciwciała LW LYME IgG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Odra przeciwciała IgG',
            'pricePLN' => 40,
            'details' => 'Przeciwciała LW MEA IgG;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Kiła - odczyn serologiczny',
            'pricePLN' => 35,
            'details' => 'LW WR;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Kiła - test potwierdzenia',
            'pricePLN' => 105,
            'details' => 'Przeciwciała LW WR POTW;wynik do 7 dni',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'Ebola',
            'pricePLN' => 50,
            'details' => 'Przeciwciała EVD;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

            DB::table('examinations')->insert([
            'name' => 'AIDS',
            'pricePLN' => 150,
            'details' => 'Leukocyty HCV;wynik w 24h',
            'created_at' => now(),
            'updated_at' => now() ]);

    }
}
