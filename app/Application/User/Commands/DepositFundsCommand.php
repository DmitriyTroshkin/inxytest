<?php
namespace App\Application\User\Commands;

use Ramsey\Uuid\UuidInterface;

final class DepositFundsCommand
{
    public function __construct(
        public readonly UuidInterface $userId,
        public readonly int $amount,
    ) {}
}