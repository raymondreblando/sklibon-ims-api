<?php

namespace App\Services\V1;

use App\Enums\Role;
use App\Http\Resources\V1\UserResource;
use App\Repositories\RoleRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserInfoRepository $userInfoRepository,
        private RoleRepository $roleRepository
    ){}

    public function save(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            $accountPayload = $this->assignRole($data['account']);

            $user = $this->userRepository->create($accountPayload);
            $this->userInfoRepository->create($user, $data['info']);

            return Response::success(
                new UserResource($this->userRepository->findById($user)),
                'Account created successfully.'
            );
        });
    }

    private function assignRole(array $payload): array
    {
        $role = !empty($payload['role']) ? $payload['role'] : $this->roleRepository->findByRole(Role::User->value);
        return [...$payload, 'role_id' => $role];
    }
}
