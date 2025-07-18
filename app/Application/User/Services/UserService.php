<?php
namespace App\Application\User\Services;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Application\User\Commands\{UpdateUserCommand, DepositFundsCommand, TransferFundsCommand};
use App\Application\User\Services\BalanceService;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private BalanceService $balanceService
    ) {}

    public function update(UpdateUserCommand $command): void
    {
        DB::transaction(function () use ($command) {
            $user = $this->userRepository->findForUpdate($command->userId);
            if (!$user) {
                throw new RuntimeException('User not found');
            }

            $user->update($command->name, $command->email, $command->age);
            $this->userRepository->save($user);
        });
    }

    public function deposit(DepositFundsCommand $command): void
    {
        DB::transaction(function () use ($command) {
            $user = $this->userRepository->findForUpdate($command->userId);
            if (!$user) {
                throw new RuntimeException('User not found');
            }

            $user->deposit($command->amount);
            $this->userRepository->save($user);
        });
    }

    public function transfer(TransferFundsCommand $command): void
    {
        // Проверка: нельзя перевести самому себе
        if ($command->fromUserId->equals($command->toUserId)) {
            throw new RuntimeException('Cannot transfer to the same user');
        }

        DB::transaction(function () use ($command) {
            $fromUser = $this->userRepository->findForUpdate($command->fromUserId);
            $toUser = $this->userRepository->findForUpdate($command->toUserId);

            if (!$fromUser || !$toUser) {
                throw new RuntimeException('User not found');
            }

            // Валидация баланса через сервис
            $this->balanceService->validateSufficientBalance($fromUser->getBalance(), $command->amount);

            $fromUser->withdraw($command->amount);
            $toUser->deposit($command->amount);

            $this->userRepository->save($fromUser);
            $this->userRepository->save($toUser);
        });
    }
}