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

    public function changePassword(string $id, string $password): JsonResponse
    {
        $user = $this->userRepository->findById($id);
        $this->userRepository->update($user, ['password' => $password]);

        return Response::success(
            new UserResource($user),
            'Password changed successfully.'
        );
    }

    public function changeProfilePicture(string $id, array $data): JsonResponse
    {
        $user = $this->userRepository->findById($id);
        $this->userRepository->update($user, $data);

        return Response::success(
            new UserResource($user),
            'Profile picture updated successfully.'
        );
    }
}
