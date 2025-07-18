<?php
namespace App\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Application\User\Services\UserService;
use App\Application\User\Commands\{UpdateUserCommand, DepositFundsCommand, TransferFundsCommand};
use App\UI\Http\Requests\{UpdateUserRequest, DepositRequest, TransferRequest};
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function update(UpdateUserRequest $request, string $id)
    {
        $command = new UpdateUserCommand(
            Uuid::fromString($id),
            $request->input('name'),
            $request->input('email'),
            $request->input('age'),
        );

        $this->userService->update($command);

        return response()->json(['status' => 'updated']);
    }

    public function deposit(DepositRequest $request, string $id)
    {
        $command = new DepositFundsCommand(
            Uuid::fromString($id),
            $request->input('amount') * 100,
        );

        $this->userService->deposit($command);

        return response()->json(['status' => 'deposited']);
    }

    public function transfer(TransferRequest $request)
    {
        $command = new TransferFundsCommand(
            Uuid::fromString($request->input('from_user_id')),
            Uuid::fromString($request->input('to_user_id')),
            $request->input('amount') * 100,
        );

        $this->userService->transfer($command);

        return response()->json(['status' => 'transferred']);
    }
}