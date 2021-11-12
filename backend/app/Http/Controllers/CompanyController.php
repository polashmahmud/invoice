<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Company::latest()->paginate());
    }


    public function store(CompanyRequest $request): \Illuminate\Http\JsonResponse
    {
        $company = Company::create($request->all());

        return response()->json([
            'data' => $company
        ], 201);
    }


    public function show(Company $company): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $company
        ]);
    }


    public function update(CompanyRequest $request, Company $company): \Illuminate\Http\JsonResponse
    {
        $company->name = $request->name;
        $company->save();

        return response()->json([
            'data' => $company
        ]);
    }


    public function destroy(Company $company): \Illuminate\Http\JsonResponse
    {
        $company->delete();
        return response()->json(['data' => []]);
    }
}
