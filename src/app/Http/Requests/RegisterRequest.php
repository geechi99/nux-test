<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'phonenumber.required' => 'Phone number is required.',
        ];
    }
}
