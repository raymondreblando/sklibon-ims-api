<?php

namespace App\Services\V1;

use App\Enums\Role;
use App\Http\Resources\V1\UserResource;
use App\Repositories\RoleRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
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
                new UserResource($this->userRepository->find($user)),
                'Account created successfully.'
            );
        });
    }

    private function assignRole(array $payload): array
    {
        if (! empty($payload['role_id'])) return $payload;

        $role = Cache::rememberForever(
            'user_role_id',
            fn () => $this->roleRepository->findByRole(Role::User->value)
        );

        return [...$payload, 'role_id' => $role];
    }
}
