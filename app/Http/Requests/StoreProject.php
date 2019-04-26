<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
            'title'=> 'bail|required',
            'description'=> 'bail|required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'description.required'=> 'Description is required',
        ];
    }
}
