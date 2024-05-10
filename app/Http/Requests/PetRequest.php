<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "category" => "required|string|max:255",
            "status" => "required|string|max:255",
            "tags" => "required|string|max:255",
            "image" => (Route::currentRouteName() == 'pet.store') ? "required|file|image|max:8096" : "nullable|file|image|max:8096",
        ];
    }
}
