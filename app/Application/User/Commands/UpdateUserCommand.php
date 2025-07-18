<?php
namespace App\Application\User\Commands;

use Ramsey\Uuid\UuidInterface;

final class UpdateUserCommand
{
    public function __construct(
        public readonly UuidInterface $userId,
        public readonly string $name,
        public readonly string $email,
        public readonly int $age,
    ) {}
}