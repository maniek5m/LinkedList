<?php

declare(strict_types=1);

namespace App\Comparator;

use App\Model\AbstractNode;

interface ComparatorInterface
{
    public function compare(AbstractNode $node1, AbstractNode $node2): int;
}
