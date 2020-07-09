<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HomeSearchRequest extends FormRequest
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
            'field' => 'required',
            'operator' => 'required|in:eq,ne,gt,gte,lt,lte,like',
            'value' => 'required',
        ];
    }

    /**
     * Return the custom error messages
     *
     * @return Array
     */
    public function messages()
    {
        return [
            'in' => 'The operator value allowed :eq,ne,gt,gte,lt,lte,like',
        ];
    }

    /**
     * Return the error messages
     *
     * @param Validator $validator
     *
     * @return HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failure',
            'message' => $validator->errors()->all()[0],
        ], 401));
    }
}
