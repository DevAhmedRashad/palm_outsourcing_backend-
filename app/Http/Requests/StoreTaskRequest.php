<?php

namespace App\Http\Requests;

use App\Domain\Tasks\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Clients can send any of: "Pending", "In Progress", "pending", "in_progress", "in-progress"
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('status') && is_string($this->input('status'))) {
            // Normalize whatever the client sends to our DB value
            try {
                $normalized = TaskStatus::fromMixed($this->input('status'))->value;
                $this->merge(['status' => $normalized]);
            } catch (\Throwable $e) {
                //the validator will catch invalid values
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'status'      => ['required', 'string', Rule::in(TaskStatus::values())],
        ];
    }
}
