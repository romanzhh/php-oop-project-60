<?php

namespace Hexlet\Validator;

class CustomValidators
{
    protected array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function push(CustomValidator $customValidator): void
    {
        $this->items[] = $customValidator;
    }

    public function getByName(string $name): CustomValidator
    {
        $customValidator = null;

        foreach ($this->items as $item) {
            if ($item->getName() === $name) {
                $customValidator = $item;
            }
        }

        return $customValidator;
    }

    private function getAllByType(string $type): array
    {
        return array_filter(
            $this->items,
            fn ($item) => $item->getType() === $type
        );
    }

    public function forString(): self
    {
        return new self($this->getAllByType('string'));
    }

    public function forNumber(): self
    {
        return new self($this->getAllByType('number'));
    }

    public function forArray(): self
    {
        return new self($this->getAllByType('array'));
    }
}
