<?php

declare(strict_types=1);

namespace App\Comparator;

use App\Model\AbstractNode;
use App\Model\IntNode;

class IntAscComparator extends AbstractComparator
{
    public function compare(AbstractNode $node1, AbstractNode $node2): int
    {
        $this->checkType($node1, $node2);

        return intval($node1->value) <=> intval($node2->value);
    }

    public function checkType(AbstractNode $node1, AbstractNode $node2): void
    {
        parent::checkType($node1, $node2);

        if (!($node1 instanceof IntNode && $node2 instanceof IntNode)) {
            throw new \TypeError('Only IntNodes are allowed for IntAscComparator');
        }
    }
}
