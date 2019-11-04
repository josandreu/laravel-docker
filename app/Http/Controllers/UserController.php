<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        dd($users->toArray());
    }

    public function show($id) {
        //$usuario = User::find($id);
        //$usuario = User::where('name', '=', 'usuario 10')->get();
        $user = User::where('name', '=', 'Carlos')
                        ->where('email', '=', 'carlos@gmail.com')
                        ->first('name');
        //dd($usuario->toArray());
        //dd($usuario->toJson());
        echo $user->toJson();
    }

    public function store() {
        //dd(\Request::all());
        // CREAMOS UN USUARIO CON LOS VALORES QUE RECIBAMOS POR POST en la url /users/?name=....
        $user = new User();
        $user->name = \Request::input('name');
        $user->email = \Request::input('email');
        $user->password = md5(\Request::input('password'));
        $user->save();
        echo $user->id;
    }

    public function edit($id) {
        // ACTUALIZAMOS EL CAMPO rol de todos los usuarios al valor que pasemos por POST/GET (en este caso GET)
        // http://local.laravel.com/users/1/edit?rol=1 (para saber la ruta -> php artisan route:list)
        $users = User::all();
        $rol = \Request::input('rol');
        foreach($users as $user) {
            $user->rol = $rol;
            $user->save();
        }
    }

    public function update() {
        // ACTUALIZAMOS EL CAMPO rol de todos los usuarios al valor que pasemos por PUT
        $users = User::all();
        $rol = \Request::input('rol');
        foreach($users as $user) {
            $user->rol = $rol;
            $user->save();
        }
        return User::all()->toJson();
    }
}
