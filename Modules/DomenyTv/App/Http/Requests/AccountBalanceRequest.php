<?php

namespace Modules\DomenyTv\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountBalanceRequest extends FormRequest
{
    protected string $llooggiinn;

    protected string $password;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }
}
