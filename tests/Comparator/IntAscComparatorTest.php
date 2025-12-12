<?php

declare(strict_types=1);

namespace App\Tests\Comparator;

use App\Comparator\IntAscComparator;
use App\Model\IntNode;
use App\Model\StringNode;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class IntAscComparatorTest extends TestCase
{
    private IntAscComparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new IntAscComparator();
    }

    #[Test]
    public function comparesCorrectly(): void
    {
        $this->assertSame(1, $this->comparator->compare(new IntNode(10), new IntNode(5)));
        $this->assertSame(0, $this->comparator->compare(new IntNode(10), new IntNode(10)));
        $this->assertSame(-1, $this->comparator->compare(new IntNode(5), new IntNode(10)));
    }

    #[Test]
    public function throwsTypeErrorForMixedTypes(): void
    {
        $this->expectException(\TypeError::class);

        $this->comparator->compare(new IntNode(1), new StringNode('string'));
    }

    #[Test]
    public function throwsTypeErrorForNonIntTypes(): void
    {
        $this->expectException(\TypeError::class);

        $this->comparator->compare(new StringNode('string'), new StringNode('string'));
    }
}
