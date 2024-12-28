<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TaskRequest extends FormRequest
{
    
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
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'long_description' => 'nullable', 
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_path' => 'nullable|mimes:mp4,mov,ogg,qt|max:100000',

            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                if ($value != Auth::id()) {
                    $fail('The user ID must match the authenticated user.');
        
                }
            }],

            
        ];
      
    }
}    