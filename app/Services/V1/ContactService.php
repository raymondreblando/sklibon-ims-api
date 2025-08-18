<?php

namespace App\Services\V1;

use App\Http\Resources\V1\ContactResource;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class ContactService
{
    public function __construct(
        private ContactRepository $contactRepository
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            ContactResource::collection($this->contactRepository->get()),
            'Contacts retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        $contact = $this->contactRepository->create($data);

        return Response::success(
            new ContactResource($contact->load('user')),
            'Contact created successfully.'
        );
    }

    public function find(Contact $contact): JsonResponse
    {
        return Response::success(
            new ContactResource($this->contactRepository->find($contact)),
            'Contact retrieved successfully.'
        );
    }
}
