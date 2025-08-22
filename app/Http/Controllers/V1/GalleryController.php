<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Gallery\StoreGalleryRequest;
use App\Models\Gallery;
use App\Services\V1\GalleryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GalleryController extends Controller
{
    public function __construct(
        private GalleryService $galleryService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        Gate::authorize('create', Gallery::class);

        $data = $request->validated();
        return $this->galleryService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
