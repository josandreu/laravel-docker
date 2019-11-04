<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteController extends Controller
{

    /**
     * DeleteController constructor.
     */
    public function __construct() {
        $this->middleware('deleteMiddleware');
    }

    public function index($token) {
        echo 'DeleteController under DeleteMiddleware';
    }
}
