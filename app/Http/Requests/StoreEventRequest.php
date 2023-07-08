<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Library\ApiResponse;


class StoreEventRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ];
    }
    public function failedValidation(Validator $validator) 
    { 
        //write your bussiness logic here otherwise it will give same old JSON response
        return ApiResponse::sendFormRequestValidationErrorResponse( $validator->errors() );
    }

}
