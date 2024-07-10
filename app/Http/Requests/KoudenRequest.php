<?php

namespace App\Http\Requests;

use App\Models\Kouden;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KoudenRequest extends FormRequest
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
            'section' => 'max:255',
            'post' => 'nullable|max:255',
            'name_kan' => 'required|max:255',
            'relation' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'price' => 'nullable|max:255',
            'created_at' => 'nullable|max:255',
            'memo' => 'nullable|max:1000'
        ];
    }
}
