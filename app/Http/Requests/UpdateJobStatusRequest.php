<?php

namespace App\Http\Requests;

use App\Enums\JobStatus;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UpdateJobStatusRequest extends FormRequest
{
    protected array $available = [
        'status',
    ];

    protected $casts = [
        'status' => 'int',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['status' => 'array'])]
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'numeric',
                Rule::in([
                    JobStatus::Active->value,
                    JobStatus::Scheduled->value,
                    JobStatus::Completed->value,
                    JobStatus::Invoicing->value,
                    JobStatus::ToPriced->value,
                ]), ],
        ];
    }

    public function getStatus(): string
    {
        return $this->getParam('status');
    }
}
