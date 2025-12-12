<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Enum\DataType;

class IntNode extends AbstractNode
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }

    public function getType(): DataType
    {
        return DataType::INT;
    }
}
