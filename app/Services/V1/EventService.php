<?php

namespace App\Services\V1;

use App\Events\EventCreated;
use App\Http\Resources\V1\EventResource;
use App\Repositories\EventRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EventService
{
    use HasAuthUser;

    public function __construct(
        private EventRepository $eventRepository
    ){}

    public function save(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            $event = $this->eventRepository->create($this->user(), $data);

            EventCreated::dispatch($event);

            return Response::success(
                new EventResource($event),
                'Event created successfully.'
            );
        });
    }
}
