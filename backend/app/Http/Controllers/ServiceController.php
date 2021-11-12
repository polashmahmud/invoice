<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Service::paginate());
    }

    public function store(ServiceRequest $request): \Illuminate\Http\JsonResponse
    {
        $service = Service::create($request->validated());

        return response()->json([
            'data' => $service
        ], 201);
    }

    public function show(Service $service): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $service
        ]);
    }

    public function update(ServiceRequest $request, Service $service): \Illuminate\Http\JsonResponse
    {
        $service->update($request->validated());

        return response()->json([
            'data' => $service->refresh(),
        ]);
    }

    public function destroy(Service $service): \Illuminate\Http\JsonResponse
    {
        $service->delete();

        return response()->json(['data' => []]);
    }
}
