<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'crmUrl' => 'required|url',
            'apiKey' => 'required'
        ];
    }
    public function messages()
    {
        return [
            "crmUrl.url" => "Введите ссылку",
            "apiKey.required" => "Поле Api-ключ обязательное",
            "crmUrl.required" => "Поле Ссылка на аккаунт retailCRM обязательное",
        ];
    }
}
