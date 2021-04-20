<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebAirtimePurchaseRequest extends FormRequest
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
            //
            'amount' => 'required|numeric|min:10|max:2000',
            'recipient' => 'required|phone:KE,UG',
            'mpesa_number' => ['required', 'phone:KE', 'regex:/(^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$)/u'],
            'nominee_number' => ['required', 'phone:KE', 'regex:/(^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$)/u'],

        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.phone' => 'The :attribute number has to be in the correct format.',
////            'phone.exists' => 'The selected phone does not exist.',
////            'name.required' => 'Name is required!',
////            'password.required' => 'Password is required!'
        ];
    }
}
