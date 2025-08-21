<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Utils\Response;
use Illuminate\Http\Request;

class ImageKitController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $imageKit = app('ImageKit\ImageKit');

        $params = $imageKit->getAuthenticationParameters();

        return Response::success($params, 'Authenticated');
    }
}
