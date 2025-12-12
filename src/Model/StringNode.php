<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Enum\DataType;

class StringNode extends AbstractNode
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function getType(): DataType
    {
        return DataType::STRING;
    }
}
