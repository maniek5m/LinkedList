<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Enum\DataType;

abstract class AbstractNode
{
    private ?AbstractNode $next = null;

    public function __construct(public readonly mixed $value)
    {
    }

    abstract public function getType(): DataType;

    public function getNext(): ?AbstractNode
    {
        return $this->next;
    }

    public function setNext(?AbstractNode $next): void
    {
        $this->next = $next;
    }
}
