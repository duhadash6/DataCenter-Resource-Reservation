<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'justification' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_at.required' => 'Start date is required.',
            'start_at.date' => 'Start date must be a valid date.',
            'start_at.after_or_equal' => 'Start date must be today or later.',
            'end_at.required' => 'End date is required.',
            'end_at.date' => 'End date must be a valid date.',
            'end_at.after' => 'End date must be after start date.',
            'justification.max' => 'Justification cannot exceed 1000 characters.',
        ];
    }
}
