<?php

namespace App\Http\Controllers\Api\Tenants;

use App\Entities\Tenant;
use App\Http\Requests\Tenants\Media\StoreRequest;
use App\Http\Controllers\Controller;

/**
 * [MediaController description]
 */
class MediaController extends Controller
{
    /**
     * Update, create or remove roles for an user.
     *
     * @param StoreRequest $request
     * @param Tenant       $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Tenant $tenant)
    {
        $currentAvatar = $tenant->getFirstMedia();

        $newMedia = $tenant->addMediaFromBase64($request->input('image'))->toMediaCollection();

        $tenant->clearMediaCollectionExcept('default', $newMedia);

        return response()->json(['avatar_url' => $newMedia->getUrl()], 201);
    }
}
