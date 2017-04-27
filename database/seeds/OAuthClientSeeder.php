<?php

use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('oauth_clients')->insert([
            [
                'id' => 'appid01',
                'secret' => 'secret',
                'name' => 'Minha aplica��o mobile - ionic',
                'created_at' =>  '26/04/2017',
                'updated_at' =>  '26/04/2017',
            ]
        ]);
    }
}
