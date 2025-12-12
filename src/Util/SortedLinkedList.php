<?php

declare(strict_types=1);

namespace App\Util;

use App\Comparator\ComparatorInterface;
use App\Model\AbstractNode;

class SortedLinkedList extends AbstractLinkedList
{
    public function __construct(private ComparatorInterface $comparator)
    {
    }

    public function add(AbstractNode $node): bool
    {
        $this->typeValidation($node);

        if (null === $this->head) {
            $this->addNodeAfter($node, null);

            return true;
        }

        $prev = null;
        $cur = $this->head;

        while (null !== $cur) {
            $res = $this->comparator->compare($cur, $node);
            if ($res > 0) {
                break;
            } elseif (0 === $res) {
                return false;
            }

            $prev = $cur;
            $cur = $cur->getNext();
        }

        $this->addNodeAfter($node, $prev);

        return true;
    }

    public function remove(AbstractNode $node): bool
    {
        $this->typeValidation($node);

        $prev = null;
        $cur = $this->head;
        $cmp = $this->comparator;

        while (null !== $cur) {
            $res = $this->comparator->compare($cur, $node);
            if ($res > 0) {
                break;
            } elseif (0 === $res) {
                $this->removeNode($cur, $prev);

                return true;
            }

            $prev = $cur;
            $cur = $cur->getNext();
        }

        return false;
    }

    public function contains(AbstractNode $node): bool
    {
        $this->typeValidation($node);

        if (null === $this->head) {
            return false;
        }

        $cur = $this->head;
        while (null !== $cur) {
            $res = $this->comparator->compare($cur, $node);
            if ($res > 0) {
                break;
            } elseif (0 === $res) {
                return true;
            }

            $cur = $cur->getNext();
        }

        return false;
    }
}
