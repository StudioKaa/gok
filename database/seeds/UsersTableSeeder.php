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
        DB::table('users')->insert([
            'name' => 'Bart Roos',
            'username' => 'bartroos',
            'password' => password_hash('Christina90', PASSWORD_BCRYPT),
            'admin' => true,
        ]);
    }
}
