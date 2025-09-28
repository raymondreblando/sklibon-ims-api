<?php

namespace App\Services\V1;

use App\Enums\EventStatus;
use App\Events\EventCreated;
use App\Events\EventStatusUpdated;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use App\Repositories\Criteria\Where;
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

    public function get(?string $barangayId): JsonResponse
    {
        if (! empty($barangayId)) {
            $criteria = [new Where('barangay_id', $barangayId)];
        }

        return Response::success(
            EventResource::collection($this->eventRepository->get($criteria ?? [])),
            'Events retrieved successfully.'
        );
    }

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

    public function find(Event $event): JsonResponse
    {
        $event = $this->eventRepository->find($event, [
            'user:id,profile',
            'user.userInfo:id,user_id,firstname,lastname',
            'barangay:id,name',
            'attendances',
            'attendances.user:id,profile',
            'attendances.user.userInfo:id,user_id,position_id,firstname,lastname',
            'attendances.user.userInfo.position'
        ]);

        return Response::success(
            new EventResource($event),
            'Event retrieved successfully.'
        );
    }

    public function update(Event $event, array $data): JsonResponse
    {
        return DB::transaction(function () use ($event, $data) {
            $event = $this->eventRepository->update($event, $data);

            if (in_array($event->status, [
                EventStatus::Ongoing->value,
                EventStatus::Completed->value,
                EventStatus::Cancelled->value
            ])) {
                EventStatusUpdated::dispatch($event);
            }

            if ($event->status === EventStatus::Archived->value) {
                $event->archivable()->create([
                    'archived_by' => $this->getAuthUserId()
                ]);
            }

            return Response::success(
                new EventResource($event),
                'Event updated successfully.'
            );
        });
    }

    public function delete(Event $event): JsonResponse
    {
        $this->eventRepository->delete($event);

        return Response::success(null, 'Event deleted successfully.');
    }
}
