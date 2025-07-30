<?php

namespace App\Http\Requests;

use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_barang' => 'required',
            'images' => 'required|mimes:png,jpg',
            'kategori' => 'required',
            'harga' => 'required|integer',
            'user_id' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return ResponseHelper::error($validator->errors(), 'maaf validasi gagal');
    }
}
