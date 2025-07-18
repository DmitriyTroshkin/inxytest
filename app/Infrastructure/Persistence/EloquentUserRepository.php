<?php
namespace App\Infrastructure\Persistence;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\ValueObjects\Balance;
use Ramsey\Uuid\UuidInterface;
use App\Models\User as UserModel;
use Ramsey\Uuid\Uuid;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(UuidInterface $id): ?User
    {
        $model = UserModel::find($id->toString());
        if (!$model) {
            return null;
        }

        return new User(
            Uuid::fromString($model->id),
            $model->name,
            $model->email,
            $model->age,
            new Balance($model->balance)
        );
    }

    public function findForUpdate(UuidInterface $id): ?User
    {
        $model = UserModel::where('id', $id->toString())->lockForUpdate()->first();
        if (!$model) {
            return null;
        }

        return new User(
            Uuid::fromString($model->id),
            $model->name,
            $model->email,
            $model->age,
            new Balance($model->balance)
        );
    }

    // TODO
    // сделать через lockForUpdate
    public function save(User $user): void
    {
        $model = UserModel::find($user->getId()->toString());
        if (!$model) {
            $model = new UserModel();
            $model->id = $user->getId()->toString();
        }

        $model->name = $user->getName();
        $model->email = $user->getEmail();
        $model->age = $user->getAge();
        $model->balance = $user->getBalance()->getAmount();

        $model->save();
    }
}