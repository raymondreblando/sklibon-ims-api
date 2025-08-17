<?php

namespace App\Services\V1;

use App\Http\Resources\V1\UserResource;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

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

    public function changeProfilePicture(string $id, UploadedFile $file): JsonResponse
    {
        $user = $this->userRepository->findById($id);
        $imageKit = app('ImageKit\ImageKit');

        $response = $imageKit->upload([
            'file' => base64_encode(file_get_contents($file->getRealPath())),
            'fileName' => "profile-{$user->id}.{$file->getClientOriginalExtension()}",
            'folder' => '/sklibon-ims/profiles',
            'useUniqueFileName' => false,
            'isPrivateFile' => false
        ]);

        if (! $response->result)
            return Response::error('Failed to upload profile picture.', 503);

        $this->userRepository->update($user, ['profile' => $response->result->url]);

        return Response::success(
            new UserResource($user),
            'Profile picture updated successfully.'
        );
    }
}
