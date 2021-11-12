<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebsiteRequest;
use App\Models\Website;

class WebsiteController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Website::latest()->paginate());
    }

    public function store(WebsiteRequest $request): \Illuminate\Http\JsonResponse
    {
        $website = Website::create($request->validated());

        return response()->json([
            'data' => $website
        ], 201);
    }

    public function show(Website $website): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $website
        ]);
    }

    public function update(WebsiteRequest $request, Website $website): \Illuminate\Http\JsonResponse
    {
        $website->update($request->validated());

        return response()->json([
            'data' => $website->refresh(),
        ]);
    }

    public function destroy(Website $website): \Illuminate\Http\JsonResponse
    {
        $website->delete();
        return response()->json(['data' => []]);
    }
}
