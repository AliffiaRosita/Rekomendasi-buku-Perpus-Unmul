<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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
            'email'  =>  str_random(10) . '@email.com',
            'password' => bcrypt('123123'),
            'role'=>'mahasiswa'
        ]];
    //     [
    //         'email'  =>  str_random(10) . '@email.com',
    //         'password' => bcrypt('123123'),
    //         'role'=>'mahasiswa'
    //     ],
    //     [
    //         'email'  =>  str_random(10) . '@email.com',
    //         'password' => bcrypt('123123'),
    //         'role'=>'mahasiswa'
    //     ],[
    //         'email'  =>  str_random(10) . '@email.com',
    //         'password' => bcrypt('123123'),
    //         'role'=>'mahasiswa'
    //     ],
    //     [
    //         'email'  =>  str_random(10) . '@email.com',
    //         'password' => bcrypt('123123'),
    //         'role'=>'mahasiswa'
    //     ]
    // ];

    foreach ($data as $item) {
        \App\User::create($item);
    }
}

}
