<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\CompanyRepository;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $repo;

    public function __construct(CompanyRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the companies.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanies(Request $request): \Illuminate\Http\JsonResponse
    {
        $min = $request->input('min');
        $max = $request->input('max');

        $companies = Company::filterByUsersAge($min, $max)
            ->get();

        return response()->json([
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created company in storage.
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'id' => 'required|string|max:10',
            'name' => 'required|string',
            'started_at' => 'required|date',
        ]);
        if($validatedData->fails())
        {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ]);
        }

        $company = $this->repo->fetchById($request->input("id"));
        if ($company) {
            return response()->json([
                "message" => "Company already exists",
            ]);
        }
        $company = $this->repo->firstOrCreate($validatedData->validate());
        return response()->json([
            "message" => "Company created successfully",
            'data' => $company,
        ]);
    }
}
