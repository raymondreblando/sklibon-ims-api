<?php

namespace App\Http\Controllers;

use App\Services\V1\Chat\ChatParticipantService;
use Illuminate\Http\Request;

class ChatParticipantController extends Controller
{
    public function __construct(
        private ChatParticipantService $chatParticipantService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queries = $request->query();
        return $this->chatParticipantService->get($queries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
