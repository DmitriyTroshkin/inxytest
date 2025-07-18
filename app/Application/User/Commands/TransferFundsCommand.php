<?php
namespace App\Application\User\Commands;

use Ramsey\Uuid\UuidInterface;

final class TransferFundsCommand
{
    public function __construct(
        public readonly UuidInterface $fromUserId,
        public readonly UuidInterface $toUserId,
        public readonly int $amount,
    ) {}
}