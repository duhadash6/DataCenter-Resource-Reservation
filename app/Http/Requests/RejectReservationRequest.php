<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'Rejection reason is required.',
            'reason.min' => 'Reason must be at least 5 characters.',
            'reason.max' => 'Reason cannot exceed 500 characters.',
        ];
    }
}
