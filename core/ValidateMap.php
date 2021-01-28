<?php

namespace core;

class ValidateMap
{
    /** @var Validate[] */
    private array $rules = [];
    private array $errors = [];

    public function setRule(Validate $validate): static
    {
        $this->rules[] = $validate;
        return $this;
    }

    public function setRules(array $rules): static
    {
        foreach ($rules as $rule) {
            $this->setRule($rule);
        }
        return $this;
    }

    public function validate(array $request): bool
    {
        $status = true;
        foreach ($this->rules as $rule) {
            if (!$rule->validate($request)) {
                $status = false;
                $this->errors[] = $rule->getName() . '[' . implode(', ', $rule->getErrors()) . ']';
            }
        }
        return $status;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}