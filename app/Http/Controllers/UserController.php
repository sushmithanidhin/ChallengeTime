<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = Validator::make($request->all(), [
                'id' => 'required|string|max:10',
                'name' => 'required|string',
                'age' => 'required|integer',
            ]);

        if($validatedData->fails())
        {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ]);
        }

        $user = $this->repo->fetchById($request->input("id"));
        if ($user) {
            return response()->json([
                "message" => "User already exists",
            ]);
        }
        $company = $this->repo->firstOrCreate($validatedData->validate());
        return response()->json([
            "message" => "User created successfully",
            'data' => $company,
        ]);
    }
}
