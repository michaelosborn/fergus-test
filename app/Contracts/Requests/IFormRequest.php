<?php

namespace App\Contracts\Requests;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Redirector;

interface IFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages();

    /**
     * @return User|Authenticatable
     */
    public function getUser(): User | Authenticatable;

    /**
     * @return int
     */
    public function getBusinessId(): int;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated();

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes();

    /**
     * Set the Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return $this
     */
    public function setValidator(Validator $validator);

    /**
     * Set the Redirector instance.
     *
     * @param  \Illuminate\Routing\Redirector  $redirector
     * @return $this
     */
    public function setRedirector(Redirector $redirector);

    /**
     * Set the container implementation.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return $this
     */
    public function setContainer(Container $container);
}
