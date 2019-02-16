<?php

namespace App\Http\Controllers\Api;

use App\Entities\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\IndexRequest;
use App\Http\Requests\Tenants\ShowRequest;
use App\Http\Requests\Tenants\StoreRequest;
use App\Http\Requests\Tenants\DeleteRequest;
use App\Http\Requests\Tenants\UpdateRequest;

class TenantsController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $query = $request->input('query');

        $orderBy    = $request->input('orderBy', $request->input('order_by', 'name'));
        $direction = $request->input('ascending', $request->input('order_direction', 'asc'));

        if (!in_array($orderBy, ['name', 'nicknames', 'id', 'number'])) {
            $sortBy = 'id';
        }

        if ($direction == 0 || strtolower($direction) === 'desc') {
            $direction = 'desc';
        } else {
            $direction = 'asc';
        }

        //TODO Implementar búsqueda
        $tenants = Tenant::where('name', 'like', "%${query}%")
            ->orWhere('nicknames', 'like', "%${query}%")
            ->orderBy($orderBy, $direction)
            ->paginate($request->input('per_page', 20), ['*'], 'page', $request->input('page', 1));

        return response()->json($tenants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $tenant = Tenant::create($request->only('name', 'nicknames', 'number', 'title_id'));

        return response()->json($tenant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Tenant      $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, Tenant $tenant)
    {
        return response()->json($tenant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Tenant        $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Tenant $tenant)
    {
        $tenant->update($request->all());

        return response()->json($tenant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param Tenant        $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, Tenant $tenant)
    {
        $tenant->delete();
        return response()->json(null, 204);
    }
}
