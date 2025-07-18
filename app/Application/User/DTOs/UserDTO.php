<?php
namespace App\Application\User\DTOs;

use App\Domain\User\Entities\User;

final class UserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly int $age,
        public readonly int $balance
    ) {}

    public static function fromEntity(User $user): self
    {
        return new self(
            $user->getId()->toString(),
            $user->getName(),
            $user->getEmail(),
            $user->getAge(),
            $user->getBalance()->getAmount()
        );
    }
}