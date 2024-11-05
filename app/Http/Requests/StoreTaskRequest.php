<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'method' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        // code...
        return [
            'method.required' => 'Mohon untuk pilih metode / buat terlebih dahulu jika belum memiliki methode',
            'name.required' => 'Tolong input nama task',
        ];
    }
}
