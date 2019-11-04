<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // se puede hacer así:
        User::create([
            'name' => 'Carlos',
            'email' => 'carlos@gmail.com',
            'password' => md5(1234),
            'token' =>  md5(date('YmdHms')),
            'rol' => 1
        ]);

        // O así:
        $user = new User;
        $user->name = 'Paco';
        $user->email = 'paco@gmail.com';
        $user->password = md5(1234);
        $user->token = md5(date('YmdHms'));
        $user->rol = 1;

        $user->save();

        // creamod varios usuarios a la vez
        for ($i = 3; $i <= 100; $i++) {
            User::create([
                'name' => 'Usuario '.$i,
                'email' => "usuario-$i@gmail.com",
                'password' => md5(1234),
                'token' =>  md5(date('YmdHms') + $i),
                'rol' => 1
            ]);
        }
    }
}
