<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Closure;

class TaskRequest extends FormRequest
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
        $task = $this->route('task'); // Ambil ID task dari route

        if ($task) {
            return [
                'title' => ['required', 'string', 'max:255', 'unique:tasks,title,' . $task->id],
                'description' => 'nullable|string',
                'assign_to' => 'nullable|integer',
                'due_date' => 'required|date',
                'status'=> [
                    'required',
                    function (string $attribute, mixed $value, Closure $fail) use($task) {
                        if (!in_array($value, ['pending', 'in progress', 'completed'])) {
                            $fail(__("'The {$attribute} must be one of the following: pending, in progress, or completed.'"));
                        }

                        if ($value === 'completed' && !in_array($task->status, ['in progress','completed'])) {
                            $fail(__("The {$attribute} cannot be changed directly from {$task->status} to {$value}. Please update to in progress first."));
                        }
                    }
                ],

            ];
        }

        return [
            'title' => ['required', 'string', 'max:255', 'unique:tasks'],
			'description' => 'nullable|string',
            'assign_to' => 'nullable|number',
            'due_date' => 'required|date',
            'status' => 'nullable|string',
        ];
    }
}
