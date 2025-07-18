<?php
namespace App\Application\User\Services;

use App\Domain\User\ValueObjects\Balance;
use DomainException;

final class BalanceService
{
    public function validateSufficientBalance(Balance $balance, int $amount): void
    {
        if ($amount <= 0) {
            throw new DomainException("Amount must be positive");
        }

        if ($balance->getAmount() < $amount) {
            throw new DomainException("Insufficient balance");
        }
    }
}