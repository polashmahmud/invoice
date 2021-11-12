<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServerRequest;
use App\Models\Server;

class ServerController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Server::paginate());
    }

    public function store(ServerRequest $request): \Illuminate\Http\JsonResponse
    {
        $server = Server::create($request->validated());

        return response()->json([
            'data' => $server
        ], 201);
    }

    public function show(Server $server): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $server
        ]);
    }

    public function update(ServerRequest $request, Server $server): \Illuminate\Http\JsonResponse
    {

        $server->update($request->validated());

        return response()->json([
            'data' => $server->refresh(),
        ]);
    }

    public function destroy(Server $server): \Illuminate\Http\JsonResponse
    {
        $server->delete();

        return response()->json(['data' => []]);
    }
}
