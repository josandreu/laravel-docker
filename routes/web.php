<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| https://laravel.com/docs/6.x/routing
|
|
    Route::verb(path, action)

    verb -> get, put, post, delete, any(comodin)

    Route::get($uri, $callback);
    Route::post($uri, $callback);
    Route::put($uri, $callback);
    Route::patch($uri, $callback);
    Route::delete($uri, $callback);
    Route::options($uri, $callback);

    LOS PARÁMETROS del path, HAN DE IR ENTRE LLAVES {}
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| UserController
|--------------------------------------------------------------------------
| Al hacer la ruta como un recurso, se trata de utilizar cada method (GET, PUT, DELETE...) que es asignado automáticamente a cada método del controlador
| Para saber a qué method pertenece cada método del controlador -> php artisan route:list
*/
Route::resource('/users', 'UserController');
//Route::get('/users/{id}', 'UserController@show');

/*
|--------------------------------------------------------------------------
| ROUTEs vemos en el controlador las REQUESTS y VALIDACIONES
|--------------------------------------------------------------------------
| The PREFIX method may be used to prefix each route in the group with a given URI.
*/
Route::get('/usuario', 'UsuarioController@index');
Route::post('/usuario', 'UsuarioController@create');
Route::put('/usuario', 'UsuarioController@store');
Route::post('/usuario/{id}', 'UsuarioController@destroy');
Route::delete('/usuario/validateuser', 'UsuarioController@validateuser');

/*
|--------------------------------------------------------------------------
| ROUTE GROUPS https://laravel.com/docs/6.x/routing#route-groups
|--------------------------------------------------------------------------
| The PREFIX method may be used to prefix each route in the group with a given URI.
*/
Route::prefix('admin')->group(function () {
    Route::get('users/{id?}', function ($id = null) {
        // Matches The "/admin/users/id?" URL
        echo 'Operación get usuarios, id opcional = '.$id;
    });
    Route::post('users', function () {
        // Matches The "/admin/users" URL
        return 'Operación post usuarios';
    });
});

/*
|--------------------------------------------------------------------------
| Sub-Domain Routing
|--------------------------------------------------------------------------
*/
Route::domain('{name}.local.laravel.com')->group(function () {
    Route::get('user/{id}', function ($name, $id) {
        // http://ejemplo.local.laravel.com/user/5
        echo 'Subdominio '.$name;
    });
});

/*
|--------------------------------------------------------------------------
| ROUTE that responds to multiple HTTP verbs
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/categories/{id}', function ($id = null) {
    echo $id;
});

/*
|--------------------------------------------------------------------------
| ROUTE that responds to all HTTP verbs
|--------------------------------------------------------------------------
*/
Route::any('/categories', function () {
    echo 'Categories';
});

/*
|--------------------------------------------------------------------------
| ROUTE manejadas desde el controlador ExampleController
|--------------------------------------------------------------------------
*/
Route::get('/example', 'ExampleController@index');
Route::get('/example/create/{id}', 'ExampleController@create');
Route::post('/example/edit/{id}', 'ExampleController@edit');
Route::post('/example/edit2/{id}', 'ExampleController@edit2');

/*
|--------------------------------------------------------------------------
| ROUTE manejadas desde el controlador TestController
|--------------------------------------------------------------------------
| en este caso esta ruta está filtrada por testMiddleware, de tal forma que si {age} es < 200 te lleva a la home
| podemos asignar el middleware así: ->middleware('testMiddleware') o incluirlo en el constructor del controlador (así está ahora)
*/
Route::post('/other/{age}', 'TestController@index');
//Route::post('/other/{age}', 'TestController@index')->middleware('testMiddleware');

Route::delete('/delete/{token?}', function(){
    echo 'Delete middleware';
})->middleware('deleteMiddleware');

Route::delete('/del/{token?}', 'DeleteController@index');

Route::post('/product', function(){
    echo 'Operación con POST';
});

Route::get('/product', function(){
    echo 'Operación con get';
});

// ? con esto decimos que el parámetro es opcional
Route::get('/product/{id?}', function(int $id){
    echo 'Operación con get, id = '.$id;
});

/*
|--------------------------------------------------------------------------
| ROUTE recogemos un id que tiene que cumplir esta regex -> '[a-zA-Z]+'
|--------------------------------------------------------------------------
*/
Route::get('/product/{id?}', function($id){
    echo 'Operación con get, id de tipo string = '.$id;
})->where(['id' => '[a-zA-Z]+']);

/*
|--------------------------------------------------------------------------
| ROUTE podemos incluir directamente una vista y pasarle datos a traves de un array
|--------------------------------------------------------------------------
*/
Route::view('/view', 'viewExample', ['name' => 'Paco el Moco']);

