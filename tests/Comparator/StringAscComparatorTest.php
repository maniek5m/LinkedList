<?php

declare(strict_types=1);

namespace App\Tests\Comparator;

use App\Comparator\StringAscComparator;
use App\Model\IntNode;
use App\Model\StringNode;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StringAscComparatorTest extends TestCase
{
    private StringAscComparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new StringAscComparator();
    }

    #[Test]
    public function comparesCorrectly(): void
    {
        $this->assertLessThan(0, $this->comparator->compare(new StringNode('apple'), new StringNode('banana')));
        $this->assertSame(0, $this->comparator->compare(new StringNode('test'), new StringNode('test')));
        $this->assertGreaterThan(0, $this->comparator->compare(new StringNode('zebra'), new StringNode('ant')));
    }

    #[Test]
    public function throwsTypeErrorForMixedTypes(): void
    {
        $this->expectException(\TypeError::class);

        $this->comparator->compare(new IntNode(1), new StringNode('string'));
    }

    #[Test]
    public function throwsTypeErrorForNonStringTypes(): void
    {
        $this->expectException(\TypeError::class);

        $this->comparator->compare(new IntNode(value: 1), new IntNode(1));
    }
}
