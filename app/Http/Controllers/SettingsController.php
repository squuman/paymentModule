<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RetailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{

    public static function editSettings() {
        $retail = new RetailController();
        $url = $_POST["crmUrl"];
        $key = $_POST["apiKey"];
        $dbEdit = DB::table('users')->where('id',Auth::id())->update([
            'url' => $url,
            'key' => $key
        ]);
        $link = $retail->linkCrm();
        dd($link);
    }
}
