<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeProfilePictureRequest;
use App\Http\Requests\V1\User\ChangePasswordRequest;
use App\Services\V1\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function __construct(
        private AccountService $accountService
    ){}

    public function changePassword(ChangePasswordRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        return $this->accountService->changePassword($id, $data['new_password']);
    }

    public function changeProfilePicture(ChangeProfilePictureRequest $request, string $id): JsonResponse
    {
        $profile = $request->file('profile');
        return $this->accountService->changeProfilePicture($id, $profile);
    }
}
