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

        // $data =[
        //     [
        //         'nama_pengunjung'  => 'Aliffia',
        //         'nim' => '123123',
        //         'fakultas'  => 'Teknik',
        //         'angkatan'=>'2016',
        //         'user_id'=> '1',
        //     ],
        //     [
        //         'nama_pengunjung'  => 'Annasya',
        //         'nim' => '123456',
        //         'fakultas'  => 'Teknik',
        //         'angkatan'=>'2016',
        //         'user_id'=> '2',
        //     ],
        //     [
        //         'nama_pengunjung'  => 'Anas',
        //         'nim' => '234234',
        //         'fakultas'  => 'Teknik',
        //         'angkatan'=>'2016',
        //         'user_id'=> '3',
        //     ],
        //     [
        //         'nama_pengunjung'  => 'Gandhi Dwi Laksono',
        //         'nim' => '345345',
        //         'fakultas'  => 'Teknik',
        //         'angkatan'=>'2016',
        //         'user_id'=> '4',
        //     ],
        //     [
        //         'nama_pengunjung'  => 'M.Ridho',
        //         'nim' => '456456',
        //         'fakultas'  => 'Teknik',
        //         'angkatan'=>'2016',
        //         'user_id'=> '5',
        //     ]
        // ];

        // foreach ($data as $item) {
        //     \App\Visitor::create($item);
        // }

    }
}
