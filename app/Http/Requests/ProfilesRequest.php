<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "profileName" => "required",
            "number" => "required",
            "costPrice" => "required",
            "payment" => "required",
            "deliveryPrice" => "required",
        ];
    }

    public function messages()
    {
        return [
            "profileName.required" => "Поле \"Имя профиля\" обязательное",
            "number.required" => "Поле \"Колонка номера заказа / трек-номера\" обязательное",
            "payment.required" => "Поле \"Денег получено\" обязательное",
            "deliveryPrice.required" => "Поле \"Стоимость доставки\" обязательное",
            "paymentPrice.required" => "Поле \"Стоимость за наложку\" обязательное",

        ];
    }
}
