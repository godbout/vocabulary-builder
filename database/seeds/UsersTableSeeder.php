<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'id' => 1,
            'name' => 'Demo',
            'email' => 'demo@sleeplessmind.com.mo',
            'password' => '$2y$10$MhrJTFQQr9B938N4MEpPm.7OQVO/Q9cbR5j0giRVsFonSn4jm0baW',
        ]);

        factory(App\User::class)->create([
            'id' => 2,
            'name' => 'Guill',
            'email' => 'guill.bout@gmail.com',
            'password' => '$2y$10$GuDJ7TBiJRwCZydDCbAGSeyaGSApmZ0PhEf1Gh/zVxlXHD9OGV936',
        ]);
    }
}
