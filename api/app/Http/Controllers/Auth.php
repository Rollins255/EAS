<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth extends Controller
{
    /**
     * login user
     */
    function login(){
        logger()->info(request());
    }
}
