<?php

declare(strict_types=1);

namespace App\Util;

use App\Model\AbstractNode;
use App\Model\Enum\DataType;

abstract class AbstractLinkedList implements LinkedListInterface
{
    protected ?AbstractNode $head = null;
    /** @var int<0, max> */
    protected int $count = 0;
    protected DataType $type = DataType::UNKNOWN;

    abstract public function add(AbstractNode $node): bool;

    abstract public function remove(AbstractNode $node): bool;

    abstract public function contains(AbstractNode $node): bool;

    public function getDataType(): DataType
    {
        return $this->type;
    }

    public function first(): ?AbstractNode
    {
        return $this->head ?? null;
    }

    public function last(): ?AbstractNode
    {
        if (null === $this->head) {
            return null;
        }

        $cur = $this->head;
        while (null !== $cur->getNext()) {
            $cur = $cur->getNext();
        }

        return $cur;
    }

    public function toArray(): array
    {
        $out = [];
        $cur = $this->head;
        while (null !== $cur) {
            $out[] = $cur;
            $cur = $cur->getNext();
        }

        return $out;
    }

    public function clear(): void
    {
        $this->head = null;
        $this->count = 0;
        $this->type = DataType::UNKNOWN;
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->toArray());
    }

    public function count(): int
    {
        return $this->count;
    }

    protected function typeValidation(AbstractNode $node): void
    {
        $valType = $node->getType();

        if (DataType::UNKNOWN !== $this->type && $valType !== $this->type) {
            throw new \TypeError(sprintf('List holds %s values, attempted to use %s', $this->type->value, $valType->value));
        }
    }

    protected function addNodeAfter(AbstractNode $newNode, ?AbstractNode $prevNode): void
    {
        if (null === $prevNode) {
            $newNode->setNext($this->head);
            $this->head = $newNode;
        } else {
            $newNode->setNext($prevNode->getNext());
            $prevNode->setNext($newNode);
        }

        if (0 === $this->count) {
            $this->type = $newNode->getType();
        }

        ++$this->count;
    }

    protected function removeNode(AbstractNode $nodeToRemove, ?AbstractNode $prevNode): void
    {
        if (null === $prevNode) {
            $this->head = $nodeToRemove->getNext();
        } else {
            $prevNode->setNext($nodeToRemove->getNext());
        }

        $this->count = max(0, $this->count - 1);
        if (0 === $this->count) {
            $this->type = DataType::UNKNOWN;
        }
    }
}
