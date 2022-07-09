<?php

namespace App\Http\Requests;

use App\Contracts\Requests\IFormRequest;
use App\Models\User;
use App\Traits\HasParams;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest implements IFormRequest
{
    protected array $available = [];

    protected array $defaults = [];

    use HasParams;

    public function initialize(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::initialize($query, $request, $attributes, $cookies, $files, $server, $content); // TODO: Change the autogenerated stub
        $this->setUserResolver(function () {
            return Auth::user();
        });

        $this->extractRequestParams();
    }

    public function getUser(): User | Authenticatable
    {
        return $this->user() ?? Auth::user();
    }

    /**
     * @return int
     */
    public function getBusinessId(): int
    {
        /** @var User $user */
        $user = $this->getUser();

        return $user->business_id;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->getParams();
    }

    /**
     * @return bool
     */
    public function usesTimestamps(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    private function extractRequestParams()
    {
        foreach ($this->available as $field) {
            $default = $this->getDefaultForField($field);
            $value = $this->get($field, $default);
            $this->setParam($field, $this->transformModelValue($field, $value));
        }
    }

    /**
     * @param $field
     * @return mixed|null
     */
    private function getDefaultForField($field)
    {
        return $this->defaults[$field] ?? null;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
