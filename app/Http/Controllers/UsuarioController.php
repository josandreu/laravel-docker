<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request as MyRequest;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Request;

class UsuarioController extends Controller
{
    public $request;

    /**
     * UsuarioController constructor.
     * @param MyRequest $request
     * Inyección por dependencia de Request en el constructor, la propiedad $request de UsuarioController contendrá una instancia del objeto de la clase Request
     * De esta forma tendremos al objeto Request disponible para cualquier método, de manera GLOBAL ($this->request)
     * También podríamos hacer la inyección en un método concreto en lugar de en el constructor
     */
    public function __construct(MyRequest $request) {
        $this->request = $request;
        //dd($request->all());
    }

    public function index() {
        echo 'Users Index<br>';
        if(\Request::has('name')) echo 'El nombre es '.\Request::input('name');
    }

    public function create() {
        echo 'Creamos usuario';
        //dd($this->request->except('name')); // que muestre todas las request, menos el valor de la key nombre
        //dd($this->request->only('category', 'name')); // que muestre el contenido de las keys name y category
        //dd($this->request->input('category')); // muestra el contenido del array category
        //---- ARCHIVO https://github.com/symfony/symfony/blob/2.7/src/Symfony/Component/HttpFoundation/File/UploadedFile.php ----\\
        if(\Request::hasFile('pdf')) {
            $file = \Request::file('pdf'); // en Postman ---> body / form-data / key (type file)
            //dd($file->getSize());
            //dd($file->getMimeType());
            dd($file->getClientOriginalName());
        }
        //dd($this->request->input('category.sports.0')); // accedemos a la posición 0 del array sports contenido en el array category
        //dd($this->request->all()); // visualizamos todas las request que envia el cliente (o nosotros por Postman para hacer pruebas)
    }

    public function store() {
        echo 'Editamos usuario<br>';
        echo $this->request->input('name'); // obtenemos únicamente la request cuyo key es = nombre
        //dd($this->request->path());
        dd($this->request->method());
        // en este caso utilizamos una FACADE, se pone la barra '\' para indicar que corresponde a 'Illuminate\Support\Facades' (mirar config/app.php)
        // podríamos incluir 'use Illuminate\Support\Facades\Request' y entonces no sería necesaria la barra
        dd(\Request::all());
    }

    //-- Usamos una Request creada por nosotros para realizar validaciones sobre el usuario a nivel del controlador, realizamos inyección de dependencias --\\
    public function validateuser(UserRequest $request) {
        echo 'Validamos usuario<br>';
    }

    // VALIDAMOS DESDE EL CONTROLADOR
    // https://laravel.com/docs/6.x/validation
    public function destroy($id) {
        echo 'Borramos user<br>';
        // guardamos en una variable la validación
        $valid = Validator::make(request()->all(), [
                'email' => 'required|email',
                'name' => 'required|min:6'
            ]
        );
        if($valid->fails()) {
            // mostramos errores, si los hay
            return response($valid->messages()->toArray(), 400);
            //dd($valid->errors());
        } else {
            return response()->json(array('success' => 'Todo ha ido bien'));
        }

    }
}
