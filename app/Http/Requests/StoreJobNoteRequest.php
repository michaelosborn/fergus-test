<?php

namespace App\Http\Requests;

class StoreJobNoteRequest extends FormRequest
{
    protected array $available = [
        'note',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'note' => 'required|string|min:5|max:255',
        ];
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->getParam('note');
    }
}
