<?php

namespace App\Services\V1;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class AccountService
{
    public function __construct(
        private UserRepository $userRepository
    ){}

    public function changePassword(User $user, string $password): JsonResponse
    {
        $this->userRepository->update($user, ['password' => $password]);

        return Response::success(
            new UserResource($user),
            'Password changed successfully.'
        );
    }

    public function changeProfilePicture(User $user, array $data): JsonResponse
    {
        $this->userRepository->update($user, $data);

        return Response::success(
            new UserResource($user),
            'Profile picture updated successfully.'
        );
    }
}
