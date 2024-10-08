<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirtimePurchaseRequest extends FormRequest
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
            'amount' => 'required|numeric|min:5|max:10000',
            'phone' => 'required|phone:KE|unique:accounts,phone',
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
            'phone.phone' => 'The phone field has to be in the correct format.',
//            'phone.exists' => 'The selected phone does not exist.',
//            'name.required' => 'Name is required!',
//            'password.required' => 'Password is required!'
        ];
    }
}
