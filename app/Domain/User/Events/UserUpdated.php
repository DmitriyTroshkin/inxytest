<?php
namespace App\Domain\User\Events;

use App\Domain\User\Entities\User;

final class UserUpdated
{
    public function __construct(public readonly User $user) {}
}