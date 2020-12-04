<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\RetailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{

	public function loginByCrm() {
		if (isset($_POST['clientId']))
        	Auth::loginUsingId($_POST['clientId'], true);
        return Redirect::route('settingsView');
    }

    public function submit(SettingsRequest $data) {
        $url = $data->input('crmUrl');
        if ($url[strlen($url)-1] == '/')
            $url = substr($url,0,strlen($url)-1);
        $key = $data->input('apiKey');

        $user = new User();
        $user->url = $url;
        $user->key = $key;
        $user->save();

        $currentUser = User::all()->where('url',$url)->toArray()[0];

        $retail = new RetailController($url,$key);
        $checkKey = $retail->checkKey();
        if ($checkKey == false)
            return Redirect::route('settings')->with("error",'Неверный ключ')->send();
        $link = $retail->linkCrm($currentUser['id']);
        return Redirect::away($url.'/admin/integration/cashPaymentModule/edit');
    }


}
