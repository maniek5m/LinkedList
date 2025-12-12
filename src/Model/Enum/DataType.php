<?php

declare(strict_types=1);

namespace App\Model\Enum;

enum DataType: string
{
    case INT = 'int';
    case STRING = 'string';
    case UNKNOWN = 'unknown';
}
