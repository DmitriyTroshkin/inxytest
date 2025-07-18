<?php
namespace Tests\Unit;

use App\Domain\User\ValueObjects\Balance;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use DomainException;

class BalanceTest extends TestCase
{
    public function test_initial_negative_balance() {
        $this->expectException(InvalidArgumentException::class);
        new Balance(-1);
    }

    public function test_add_and_subtract() {
        $b = new Balance(100);
        $b2 = $b->add(50);
        $this->assertEquals(150, $b2->getAmount());
        $b3 = $b2->subtract(70);
        $this->assertEquals(80, $b3->getAmount());
    }

    public function test_insufficient_subtract() {
        $b = new Balance(30);
        $this->expectException(DomainException::class);
        $b->subtract(40);
    }
}