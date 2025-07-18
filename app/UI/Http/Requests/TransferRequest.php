<?php
namespace App\UI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_user_id' => 'required|uuid',
            'to_user_id' => 'required|uuid|different:from_user_id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}