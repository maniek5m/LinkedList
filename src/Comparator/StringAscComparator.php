<?php

declare(strict_types=1);

namespace App\Comparator;

use App\Model\AbstractNode;
use App\Model\StringNode;

class StringAscComparator extends AbstractComparator
{
    public function compare(AbstractNode $node1, AbstractNode $node2): int
    {
        $this->checkType($node1, $node2);

        return strcmp($node1->value, $node2->value);
    }

    public function checkType(AbstractNode $node1, AbstractNode $node2): void
    {
        parent::checkType($node1, $node2);

        if (!($node1 instanceof StringNode && $node2 instanceof StringNode)) {
            throw new \TypeError('Only StringNodes are allowed for StringAscComparator');
        }
    }
}
