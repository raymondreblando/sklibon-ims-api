<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Account\ChangeProfilePictureRequest;
use App\Http\Requests\V1\Account\ChangePasswordRequest;
use App\Http\Requests\V1\Account\UpdateProfileRequest;
use App\Services\V1\AccountService;
use App\Services\V1\UserService;
use App\Traits\Auth\HasAuthUser;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    use HasAuthUser;

    public function __construct(
        private AccountService $accountService,
        private UserService $userService
    ){}

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->accountService->changePassword($this->user(), $data['new_password']);
    }

    public function changeProfilePicture(ChangeProfilePictureRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->accountService->changeProfilePicture($this->user(), $data);
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->userService->update($this->user(), $data);
    }
}
