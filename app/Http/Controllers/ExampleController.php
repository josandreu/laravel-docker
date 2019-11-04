<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ExampleController extends Controller
{
    public function index() {
        echo 'Hola guapo ; )';
    }

    public function create($id) {
        echo 'Eres un mierdas, con id = '.$id;
    }

    // IMPORTANTE
    // Vemos que hay dos funciones edit y edit2 muy similares
    // Se han dejado para ver cómo acceder a una clase de formas diferentes
    // en edit, se accede a (vendor/laravel/framework/src) Illuminate\Http\Request, por eso se pone \Request::url(), ya que es el namespace
    // en edit2, se inyecta la clase Request como dependencia y ya la tenemos disponible
    public function edit($id) {
        echo 'Editando desde Controller';
        echo 'ID = '.$id;
        $url = \Request::url();
        $input = \Request::all(); // accedemos a los datos de entrada y los guardamos
        dd($input); // debugger de Laravel
    }

    public function edit2(Request $request, $id) {
        echo 'Editando desde Controller';
        echo '<br>';
        echo 'El ID = '.$id;
        $url = $request->url();
        $input = $request->all(); // accedemos a los datos de entrada y los guardamos
        dd($input); // debugger de Laravel
    }
}
