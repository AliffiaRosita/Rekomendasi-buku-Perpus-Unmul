<?php

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;

class RatingTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = 'rating';
        $this->filename = base_path().'/database/seeds/rating_seeder.csv';
    }
    public function run()
    {
        parent::run();

        $this->command->getOutput()->progressStart(10);
        for ($i = 0; $i < 10; $i++) {
            sleep(1);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        // $data = [
        //     [
        //     'buku_id'  =>  '1',
        //     'pengunjung_id' =>'1' ,
        //     'nilai'=>'6',
        // ],
        // [
        //     'buku_id'  =>  '4',
        //     'pengunjung_id' =>'1' ,
        //     'nilai'=>'8',
        // ],  [
        //     'buku_id'  =>  '1',
        //     'pengunjung_id' =>'2' ,
        //     'nilai'=>'2',
        // ],  [
        //     'buku_id'  =>  '2',
        //     'pengunjung_id' =>'2' ,
        //     'nilai'=>'10',
        // ],  [
        //     'buku_id'  =>  '2',
        //     'pengunjung_id' =>'3' ,
        //     'nilai'=>'3',
        // ],  [
        //     'buku_id'  =>  '3',
        //     'pengunjung_id' =>'3' ,
        //     'nilai'=>'1',
        // ],
        // [
        //     'buku_id'  =>  '1',
        //     'pengunjung_id' =>'4' ,
        //     'nilai'=>'2',
        // ], [
        //     'buku_id'  =>  '2',
        //     'pengunjung_id' =>'4' ,
        //     'nilai'=>'3',
        // ], [
        //     'buku_id'  =>  '3',
        //     'pengunjung_id' =>'4' ,
        //     'nilai'=>'2',
        // ], [
        //     'buku_id'  =>  '4',
        //     'pengunjung_id' =>'4' ,
        //     'nilai'=>'1',
        // ], [
        //     'buku_id'  =>  '3',
        //     'pengunjung_id' =>'1' ,
        //     'nilai'=>'1',
        // ],
        // [
        //     'buku_id'  =>  '5',
        //     'pengunjung_id' =>'4' ,
        //     'nilai'=>'5',
        // ], [
        //     'buku_id'  =>  '5',
        //     'pengunjung_id' =>'1' ,
        //     'nilai'=>'4',
        // ]
    // ];

    // foreach ($data as $item) {
    //     \App\Rating::create($item);
    // }
    }
}
