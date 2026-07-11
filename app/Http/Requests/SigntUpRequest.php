<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigntUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "full_name" => "required|string|max:255",
            "national_id" => "required|numeric|unique:customers",
            "phone_number" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:customers",
            "password" => "required|string|min:8",
            "confirm_password" => "required_with:password|same:password|min:8",
        ];
    }
}
