<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InviteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'  => ['required', 'string',],
            'email' => ['required', 'email', 'unique:users,email'],
        ];

        if ($this->user()->role == UserRole::ADMIN) {
            $rules['role'] = [
                'required',
                Rule::in([UserRole::ADMIN->value, UserRole::MEMBER->value])
            ];
        }

        return $rules;
    }
}
