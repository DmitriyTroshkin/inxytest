<?php
namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\Balance;
use App\Domain\User\Events\UserUpdated;
use Ramsey\Uuid\UuidInterface;

final class User
{
    private Balance $balance;

    public function __construct(
        private UuidInterface $id,
        private string $name,
        private string $email,
        private int $age,
        ?Balance $balance = null
    ) {
        $this->balance = $balance ?? new Balance(0);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }

    /**
     * Обновляет поля пользователя и возвращает событие UserUpdated
     */
    public function update(string $name, string $email, int $age): UserUpdated
    {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;

        return new UserUpdated($this);
    }

    /**
     * Пополнение баланса
     */
    public function deposit(int $amount): void
    {
        $this->balance = $this->balance->add($amount);
    }

    /**
     * Снятие средств с баланса
     */
    public function withdraw(int $amount): void
    {
        $this->balance = $this->balance->subtract($amount);
    }
}