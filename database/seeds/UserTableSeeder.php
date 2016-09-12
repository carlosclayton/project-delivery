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

        factory(\Delivery\Models\User::class)->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ]);

        factory(\Delivery\Models\User::class)->create([
            'name' => 'Teste',
            'email' => 'teste@user.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ]);

        factory(\Delivery\Models\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt(123456),
            'role' => 'admin',
            'remember_token' => str_random(10),
        ]);

        factory(\Delivery\Models\User::class, 10)->create()->each(function($u){
            $u->client()->save(factory(\Delivery\Models\Client::class)->make());
        });

        factory(\Delivery\Models\User::class, 3)->create([
            'role' => 'deliveryman',
        ]);


    }
}
