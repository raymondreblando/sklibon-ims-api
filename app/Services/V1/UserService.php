<?php

namespace App\Services\V1;

use App\Enums\Role;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
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

    public function get(): JsonResponse
    {
        return Response::success(
            UserResource::collection($this->userRepository->get()),
            'Users retrieved successfully.'
        );
    }

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

    public function find(User $user): JsonResponse
    {
        return Response::success(
            new UserResource($this->userRepository->find($user)),
            'User retrieved successfully.'
        );
    }

    public function update(User $user, array $data): JsonResponse
    {
        return DB::transaction(function () use ($user, $data) {
            $this->userRepository->update($user, $data['account']);
            $this->userInfoRepository->update($user, $data['info']);

            return Response::success(
                new UserResource($this->userRepository->find($user)),
                'User updated successfully.'
            );
        });
    }

    public function delete(User $user): JsonResponse
    {
        $this->userRepository->delete($user);

        return Response::success(null, 'User deleted successfully.');
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
