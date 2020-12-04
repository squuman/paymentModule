<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfilesRequest;

class ProfilesController extends Controller {
    //
    public function submit(ProfilesRequest $data) {

        $profile = new Profile();
        $profile->profileName = $data->input("profileName");
        $profile->searchMethod = $data->input("trackNumber") == "on" ? "trackNumber" : "orderNumber";
        $profile->type = $data->input("profileType");
        $profile->number = $data->input("number");
        $profile->payment = $data->input("payment");
        $profile->deliveryPrice = $data->input("deliveryPrice");
        $profile->createCostDelivery = $data->input("createCostDelivery") == "on" ? "on" : "off";
        $profile->deliveryCostCode = $data->input("deliveryCostCode");
        $profile->deliveryCost = $data->input("deliveryCost");
        $profile->costPrice = $data->input("costPrice");
        $profile->createCost = $data->input("createCost") == "on" ? "on" : "off";
        $profile->costCode = $data->input("costCode");
        $profile->paymentCode = $data->input("paymentCode");
        $profile->changePaymentStatus = $data->input("changePaymentStatus") == "on" ? "on" : "off";
        $profile->userId = $data->input("userId");

        $profile->save();

        return redirect()->route("profiles")->with("success", "Профиль успешно добавлен");
    }

    public static function allData() {
        $profile = new Profile();
//        $profile->all();

        return $profile->all();
    }
}
