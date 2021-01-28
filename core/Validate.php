<?php

namespace core;

use JetBrains\PhpStorm\Pure;

class Validate
{
    private const REQUIRED = 1;
    private const STRING = 2;
    private const INTEGER = 3;
    private array $rules = [];
    private array $errors = [];

    public function __construct(
        private string $name
    )
    {
    }

    #[Pure]
    public static function name(string $name): static
    {
        return new static($name);
    }

    public function required(): static
    {
        $this->rules[self::REQUIRED] = 1;
        return $this;
    }

    public function string(?int $lengthMin = null, ?int $lengthMax = null): static
    {
        $this->rules[self::STRING] = [$lengthMin, $lengthMax];
        return $this;
    }

    public function integer(?int $min = null, ?int $max = null)
    {
        $this->rules[self::INTEGER] = [$min, $max];
    }

    public function validate(array $request): bool
    {
        if (!isset($request[$this->name])) {
            if ($this->rules[self::REQUIRED] === 1) {
                $this->errors[] = 'REQUIRED';
                return false;
            }
            return true;
        }

        $value = $request[$this->name];

        foreach ($this->rules as $rule => $params) {
            switch ($rule) {
                case self::STRING:
                    $len = mb_strlen($value);
                    if ($params[0] !== null && $len < $params[0]) {
                        $this->errors[] = "{$len} < {$params[0]}";
                        return false;
                    }
                    if ($params[1] !== null && $len > $params[1]) {
                        $this->errors[] = "{$len} > {$params[1]}";
                        return false;
                    }
                    break;
                case self::INTEGER:
                    $int = intval($value);
                    if (strval($value) !== strval($int)) return false;
                    if ($params[0] !== null && $int < $params[0]) {
                        $this->errors[] = "{$int} < {$params[0]}";
                        return false;
                    }
                    if ($params[1] !== null && $int > $params[1]) {
                        $this->errors[] = "{$int} > {$params[1]}";
                        return false;
                    }
                    break;
            }
        }
        return true;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}