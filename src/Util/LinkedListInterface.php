<?php

declare(strict_types=1);

namespace App\Util;

use App\Model\AbstractNode;
use App\Model\Enum\DataType;
use IteratorAggregate;

/**
 * @extends \IteratorAggregate<int|string, AbstractNode>
 */
interface LinkedListInterface extends \Countable, IteratorAggregate
{
    public function add(AbstractNode $node): bool;

    public function remove(AbstractNode $node): bool;

    public function contains(AbstractNode $node): bool;

    public function first(): ?AbstractNode;

    public function last(): ?AbstractNode;

    /** @return array<mixed> */
    public function toArray(): array;

    public function count(): int;

    public function clear(): void;

    public function isEmpty(): bool;

    public function getDataType(): DataType;
}
