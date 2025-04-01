<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|date_format:Y-m-d', 
            'category' => 'required|date_format:H:i',
            'quantity' => 'required|date_format:H:i|after:start_time', 
            'location' => 'required|exists:departments,id',
            'threshold;' => 'required|exists:departments,id',
        ];
    }
}
