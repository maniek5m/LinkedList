<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Comparator\IntAscComparator;
use App\Comparator\StringAscComparator;
use App\Model\Enum\DataType;
use App\Model\IntNode;
use App\Model\StringNode;
use App\Util\SortedLinkedList;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SortedLinkedListTest extends TestCase
{
    private SortedLinkedList $list;

    protected function setUp(): void
    {
        $this->list = new SortedLinkedList(new IntAscComparator());

        $this->list->add(new IntNode(9));
        $this->list->add(new IntNode(5));
        $this->list->add(new IntNode(7));
        $this->list->add(new IntNode(15));
        $this->list->add(new IntNode(3));
    }

    #[Test]
    public function insertIntsKeepsOrder(): void
    {
        $this->assertSame(DataType::INT, $this->list->getDataType());
        $this->assertCount(5, $this->list);
        $this->assertSame(
            [3, 5, 7, 9, 15],
            array_map(fn ($node) => $node->value, $this->list->toArray())
        );
    }

    #[Test]
    public function insertStringsKeepsOrder(): void
    {
        $this->list = new SortedLinkedList(new StringAscComparator());
        $this->list->add(new StringNode('beta'));
        $this->list->add(new StringNode('alpha'));
        $this->list->add(new StringNode('gamma'));

        $this->assertSame(DataType::STRING, $this->list->getDataType());
        $this->assertCount(3, $this->list);
        $this->assertSame(
            ['alpha', 'beta', 'gamma'],
            array_map(fn ($node) => $node->value, $this->list->toArray())
        );
    }

    #[Test]
    public function throwsTypeMismatch(): void
    {
        $this->expectException(\TypeError::class);

        $this->list->add(new StringNode('string'));
    }

    #[Test]
    public function duplicatesNotAllowed(): void
    {
        $this->assertTrue($this->list->contains(new IntNode(9)));
        $this->assertFalse($this->list->add(new IntNode(9)));
        $this->assertSame(
            [3, 5, 7, 9, 15],
            array_map(fn ($node) => $node->value, $this->list->toArray())
        );
    }

    #[Test]
    public function containsWorksCorrectly(): void
    {
        $this->assertTrue($this->list->contains(new IntNode(3)));
        $this->assertTrue($this->list->contains(new IntNode(9)));
        $this->assertTrue($this->list->contains(new IntNode(15)));

        $this->assertFalse($this->list->contains(new IntNode(2)));
        $this->assertFalse($this->list->contains(new IntNode(10)));
        $this->assertFalse($this->list->contains(new IntNode(16)));
    }

    #[Test]
    public function removeWorksCorrectly(): void
    {
        $this->assertTrue($this->list->remove(new IntNode(3)));
        $this->assertSame(
            [5, 7, 9, 15],
            array_map(fn ($node) => $node->value, $this->list->toArray())
        );

        $this->assertTrue($this->list->remove(new IntNode(15)));
        $this->assertSame(
            [5, 7, 9],
            array_map(fn ($node) => $node->value, $this->list->toArray())
        );

        $this->assertTrue($this->list->remove(new IntNode(7)));
        $this->assertTrue($this->list->remove(new IntNode(5)));
        $this->assertTrue($this->list->remove(new IntNode(9)));

        $this->assertSame([], $this->list->toArray());
        $this->assertCount(0, $this->list);
        $this->assertSame(DataType::UNKNOWN, $this->list->getDataType());
    }

    #[Test]
    public function removeNonExistingElementReturnsFalse(): void
    {
        $this->assertFalse($this->list->remove(new IntNode(99999)));
        $this->assertSame(
            [3, 5, 7, 9, 15],
            array_map(fn ($node) => $node->value, $this->list->toArray())
        );
    }

    #[Test]
    public function iteratorWorksCorrectly(): void
    {
        $this->assertEquals(3, $this->list->first()?->value);
        $this->assertEquals(15, $this->list->last()?->value);

        $collected = array_map(fn ($node) => $node->value, iterator_to_array($this->list));
        $this->assertEquals([3, 5, 7, 9, 15], $collected);
    }

    #[Test]
    public function clearWorksCorrectly(): void
    {
        $this->assertSame(DataType::INT, $this->list->getDataType());
        $this->assertCount(5, $this->list);

        $this->list->clear();

        $this->assertSame(DataType::UNKNOWN, $this->list->getDataType());
        $this->assertCount(0, $this->list);
    }
}
