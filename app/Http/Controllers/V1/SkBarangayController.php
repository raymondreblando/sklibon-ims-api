<?php

namespace App\Http\Controllers\V1;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\Barangay;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereHas;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SkBarangayController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $barangayCode, UserRepository $userRepository,)
    {
        $barangayId = Barangay::where('code', $barangayCode)->value('id');

        $criteria = [
            new Where('status', UserStatus::Verified->value),
            new WhereHas('userInfo', function (Builder $query) use ($barangayId) {
                $query->where('barangay_id', $barangayId);
            })
        ];

        return Response::success(
            UserResource::collection($userRepository->get($criteria)),
            'Users retrieved successfully.'
        );
    }
}
