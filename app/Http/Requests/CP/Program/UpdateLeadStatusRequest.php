<?php

namespace App\Http\Requests\CP\Lead;

use App\Models\Constant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_id' => ['required', 'exists:' . Constant::ui['table'] . ',id']
        ];
    }
}
