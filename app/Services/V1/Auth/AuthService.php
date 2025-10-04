<?php

namespace App\Services\V1\Auth;

use App\Enums\UserStatus;
use App\Exceptions\InvalidUserCredentialsException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\V1\UserService;
use App\Traits\Auth\IssueApiTokens;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    use IssueApiTokens;

    protected string $authMessage = 'Authentication successful.';

    public function __construct(
        private RefreshTokenService $refreshTokenService,
        private UserService $userService,
        private UserRepository $userRepository
    ){}

    public function register(array $data): JsonResponse
    {
        return $this->userService->save($data);
    }

    public function authenticate(array $data, ?string $clientType): JsonResponse
    {
        return DB::transaction(function () use ($data, $clientType) {
            $credentials = array_merge($data, ['status' => UserStatus::Verified->value]);

            if (! Auth::attempt($credentials))
                throw new InvalidUserCredentialsException();

            $user = $this->userRepository->find(Auth::user());
            $this->userRepository->update($user, ['is_online' => true]);

            $user->tokens()->delete();
            $tokens = $this->generateUserToken($user);

            return $this->issueApiToken($user, $tokens, $clientType);
        });
    }

    public function logout(): JsonResponse
    {
        return DB:: transaction(function () {
            $user = Auth::user();

            $this->userRepository->update($user, ['is_online' => false]);

            $user->tokens()->delete();
            $user->refreshTokens()->delete();

            return Response::success(null, 'Logout successful.');
        });
    }
}
