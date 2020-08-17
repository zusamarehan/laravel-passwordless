<?php

namespace App\Http\Requests;

use App\MagicCredentials;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class LoginRequest extends FormRequest
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
            'email' => ['email', 'required', 'exists:users']
        ];
    }


    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if($validator->errors()->isEmpty()) {
            $validator->after(function () {
                $user_id = User::query()
                    ->findUserByEmail(request()->input('email'))
                    ->first();

                MagicCredentials::query()
                    ->whereIn('user_id', $user_id)
                    ->delete();
            });
        }
    }
}
