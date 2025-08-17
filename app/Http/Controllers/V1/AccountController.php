<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\ChangePasswordRequest;
use App\Services\V1\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function changePassword(
        ChangePasswordRequest $request,
        AccountService $accountService,
        string $id
    ): JsonResponse {
        $data = $request->validated();
        return $accountService->changePassword($id, $data['new_password']);
    }
}
