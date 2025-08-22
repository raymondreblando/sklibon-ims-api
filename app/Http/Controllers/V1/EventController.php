<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Event\StoreEventRequest;
use App\Models\Event;
use App\Services\V1\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', Event::class);

        $barangayId = $request->query('barangay-id');
        return $this->eventService->get($barangayId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        Gate::authorize('create', Event::class);

        $data = $request->validated();
        return $this->eventService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): JsonResponse
    {
        Gate::authorize('view', $event);

        return $this->eventService->find($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
