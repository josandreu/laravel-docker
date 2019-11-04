<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * TestController constructor.
     */
    public function __construct() {
        $this->middleware('testMiddleware');
    }

    public function index(Request $request, $age) {
        echo $age;
        dd($request->all());
    }
}
