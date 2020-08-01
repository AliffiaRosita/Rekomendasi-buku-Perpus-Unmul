<?php

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;


class VisitorTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function __construct()
     {
         $this->table = 'pengunjung';
         $this->filename = base_path().'/database/seeds/pengunjung_seeder.csv';
     }
    public function run()
    {
        DB::disableQueryLog(); //jk besar pastikan pakai diSableQueryLog
        //DB::table($this->table)->truncate();
        parent::run();

        $this->command->getOutput()->progressStart(10);
        for ($i = 0; $i < 10; $i++) {
            sleep(1);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }
}
