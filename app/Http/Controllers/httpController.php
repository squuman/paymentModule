<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class httpController extends Controller
{
    public static function prevPUrl() {
        return $_SERVER['HTTP_REFERER'];
    }
}
