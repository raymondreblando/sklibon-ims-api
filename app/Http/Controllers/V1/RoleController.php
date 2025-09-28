<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RoleResource;
use App\Models\Role;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        return Response::success(
            RoleResource::collection(Role::all()),
            'Roles retrieved successfully.'
        );
    }
}
