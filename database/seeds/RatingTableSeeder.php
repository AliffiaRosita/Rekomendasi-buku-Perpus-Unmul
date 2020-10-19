<?php

use Illuminate\Database\Seeder;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'buku_id'  =>  '1',
            'pengunjung_id' =>'1' ,
            'nilai'=>'6',
        ],
        [
            'buku_id'  =>  '4',
            'pengunjung_id' =>'1' ,
            'nilai'=>'8',
        ],  [
            'buku_id'  =>  '1',
            'pengunjung_id' =>'2' ,
            'nilai'=>'2',
        ],  [
            'buku_id'  =>  '2',
            'pengunjung_id' =>'2' ,
            'nilai'=>'10',
        ],  [
            'buku_id'  =>  '2',
            'pengunjung_id' =>'3' ,
            'nilai'=>'3',
        ],  [
            'buku_id'  =>  '3',
            'pengunjung_id' =>'3' ,
            'nilai'=>'1',
        ],
        [
            'buku_id'  =>  '1',
            'pengunjung_id' =>'4' ,
            'nilai'=>'2',
        ], [
            'buku_id'  =>  '2',
            'pengunjung_id' =>'4' ,
            'nilai'=>'3',
        ], [
            'buku_id'  =>  '3',
            'pengunjung_id' =>'4' ,
            'nilai'=>'2',
        ], [
            'buku_id'  =>  '4',
            'pengunjung_id' =>'4' ,
            'nilai'=>'1',
        ], [
            'buku_id'  =>  '3',
            'pengunjung_id' =>'1' ,
            'nilai'=>'1',
        ],
        [
            'buku_id'  =>  '5',
            'pengunjung_id' =>'4' ,
            'nilai'=>'5',
        ], [
            'buku_id'  =>  '5',
            'pengunjung_id' =>'1' ,
            'nilai'=>'4',
        ]
    ];

    foreach ($data as $item) {
        \App\Rating::create($item);
    }
    }
}
