<?php

namespace App\Http\Requests;

use App\Enums\JobStatus;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class JobListRequest extends FormRequest
{
    protected array $available = [
        'q',
        'status',
        'sort',
        'direction',
    ];

    protected array $defaults = [
        'q' => false,
        'status' => false,
        'sort' => 'id',
        'direction' => 'asc',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['direction' => 'string'])]
    public function rules(): array
    {
        return [
            'status' => [
                'numeric',
                Rule::in([
                    JobStatus::Active->value,
                    JobStatus::Scheduled->value,
                    JobStatus::Completed->value,
                    JobStatus::Invoicing->value,
                    JobStatus::ToPriced->value,
                ]), ],
            'sort' => 'in:id,label,status,created_at,updated_at',
            'direction' => 'in:asc,desc',
        ];
    }

    /**
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->getParam('sort');
    }

    /**
     * @return string
     */
    public function getSortDirection(): string
    {
        return $this->getParam('direction');
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->getParam('q');
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getParam('status');
    }
}
