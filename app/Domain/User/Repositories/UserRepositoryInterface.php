<?php
namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function findById(UuidInterface $id): ?User;

    public function save(User $user): void;
}