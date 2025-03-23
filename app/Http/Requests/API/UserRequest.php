<?php

namespace App\Http\Requests\API;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:100|confirmed',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Kiểm tra nếu có lỗi trùng email
        if (request()->isMethod('post') && request()->has('email')) {
            $email = request()->input('email');
            if (User::where('email', $email)->exists()) {
                $response = response()->json([
                    'errors' => [
                        'field' => 'email',
                        'message' => 'Email đã tồn tại'
                    ],
                ], Response::HTTP_BAD_REQUEST);

                throw new HttpResponseException($response);
            }
        }

        $response = response()->json([
            'errors' => $errors->messages(),
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
}
