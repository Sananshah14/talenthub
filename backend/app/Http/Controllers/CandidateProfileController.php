<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CandidateProfileController extends Controller
{
    public function store(StoreCandidateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $request->user();

        if ($user->candidateProfile()->exists()) {
            return response()->json([
                'message' => 'Candidate profile already exists.',
            ], 409);
        }

        $profile = $user->candidateProfile()->create($data);

        return response()->json([
            'message' => 'Candidate profile created successfully.',
            'data' => $profile,
        ], 201);
    }

    //Get the logged-in candidate's profile
    public function show(Request $request): JsonResponse
    {
            $user = $request->user();

            $profile = $user->candidateProfile;

            if (!$profile) {
                return response()->json([
                    'message' => 'Candidate profile not found.',
                ], 404);
            }

            return response()->json([
                'message' => 'Candidate profile retrieved successfully.',
                'data' => $profile,
            ]);
    }

    public function update(UpdateCandidateProfileRequest $request): JsonResponse
    {
        $user = $request->user();

        $profile = $user->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        $profile->update($request->validated());

        return response()->json([
            'message' => 'Candidate profile updated successfully.',
            'data' => $profile->fresh(),
        ], 200);
    }
}
