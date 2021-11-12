<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(User::latest()->paginate());
    }

    public function store(CustomerRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'data' => $user
        ], 201);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json([
            'data' => $user
        ]);
    }


    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $request->validate(['name' => 'required']);

        $user = User::findOrFail($id);

        $user->update(['name' => $request->name]);

        return response()->json([
            'data' => $user
        ]);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'data' => []
        ]);
    }
}
