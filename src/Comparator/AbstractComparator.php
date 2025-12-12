<?php

declare(strict_types=1);

namespace App\Comparator;

use App\Model\AbstractNode;

abstract class AbstractComparator implements ComparatorInterface
{
    protected function checkType(AbstractNode $node1, AbstractNode $node2): void
    {
        if ($node1->getType() !== $node2->getType()) {
            throw new \TypeError('Incompatible types for comparison');
        }
    }
}
