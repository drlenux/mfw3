<?php


namespace core;


trait ValidateTrait
{
    abstract public function rules(): ValidateMap;

    public function validate(array $request): void
    {
        $validate = $this->rules();
        $status = $validate->validate($request);
        if (!$status) {
            throw new \Exception('bad format ' . implode(', ', $validate->getErrors()));
        }
    }
}