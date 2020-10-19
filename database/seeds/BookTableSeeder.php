<?php

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;

class BookTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = 'buku';
        $this->filename = base_path().'/database/seeds/buku_seeder.csv';
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

        // $data = [
        //     [
        //         'judul'  => 'Fruits',
        //         'isbn' => '1615243718',
        //         'penerbit'  => 'Andi',
        //         'tempat_terbit'=>'jakarta'
        //     ],
        //     [
        //         'judul'  => 'Komputer dan sains',
        //         'isbn' => '1615243748',
        //         'penerbit'  => 'Andi',
        //         'tempat_terbit'=>'jakarta'
        //     ],
        //     [
        //         'judul'  => 'Fruit Store',
        //         'isbn' => '1615243710',
        //         'penerbit'  => 'Andi',
        //         'tempat_terbit'=>'jakarta'
        //     ],
        //     [
        //         'judul'  => 'Wacom Tutorial',
        //         'isbn' => '1615243718',
        //         'penerbit'  => 'Andi',
        //         'tempat_terbit'=>'jakarta'
        //     ],
        //     [
        //         'judul'  => 'Pelajari Corel 30 hari',
        //         'isbn' => '1615243218',
        //         'penerbit'  => 'Andi',
        //         'tempat_terbit'=>'jakarta'
        //     ],
        //     [
        //         'judul'  => 'Tips dan Trik Belajar',
        //         'isbn' => '1615243768',
        //         'penerbit'  => 'Andi',
        //         'tempat_terbit'=>'jakarta'
        //     ]
        // ];

        // foreach ($data as $item) {
        //     \App\Book::create($item);
        // }
    }
}
