<?php
namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;
use DomainException;

final class Balance
{
    private int $amount;

    public function __construct(int $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException("Balance can't be negative");
        }
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function add(int $value): Balance
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Add amount must be positive");
        }

        return new Balance($this->amount + $value);
    }

    public function subtract(int $value): Balance
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Subtract amount must be positive");
        }
        if ($value > $this->amount) {
            throw new DomainException("Insufficient balance");
        }

        return new Balance($this->amount - $value);
    }
}