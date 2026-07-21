<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateProfileRequest;
use App\Http\Requests\UpdateCandidateProfileRequest;
use App\Http\Requests\UploadResumeRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\StoreCandidateSkillsRequest;
use App\Models\Education;
use Illuminate\Support\Facades\Storage;
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

    public function uploadResume(UploadResumeRequest $request): JsonResponse
    {
        // Get the authenticated user
        $user = $request->user();

        // Get the candidate profile
        $profile = $user->candidateProfile;

        // Safety check
        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Remember the old resume path
        $oldResumePath = $profile->resume_path;

        // Get uploaded file
        $resume = $request->file('resume');

        // Store the new resume
        $newResumePath = $resume->store('resumes', 'public');

        // Update database
        $profile->update([
            'resume_path' => $newResumePath,
        ]);

        // Delete old resume (if it exists)
        if (
            $oldResumePath &&
            Storage::disk('public')->exists($oldResumePath)
        ) {
            Storage::disk('public')->delete($oldResumePath);
        }

        return response()->json([
            'message' => 'Resume uploaded successfully.',
            'resume_path' => $newResumePath,
        ], 200);
    }

    public function uploadAvatar(UploadAvatarRequest $request): JsonResponse
    {
        // Get the authenticated user
        $user = $request->user();

        // Get candidate profile
        $profile = $user->candidateProfile;

        // Ensure profile exists
        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Remember the old avatar path
        $oldAvatarPath = $profile->avatar_path;

        // Get uploaded image
        $avatar = $request->file('avatar');

        // Store the new avatar
        $newAvatarPath = $avatar->store('avatars', 'public');

        // Update database
        $profile->update([
            'avatar_path' => $newAvatarPath,
        ]);

        // Delete old avatar
        if (
            $oldAvatarPath &&
            Storage::disk('public')->exists($oldAvatarPath)
        ) {
            Storage::disk('public')->delete($oldAvatarPath);
        }

        return response()->json([
            'message' => 'Avatar uploaded successfully.',
            'avatar_path' => $newAvatarPath,
        ], 200);
    }

    public function indexEducation(Request $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Education records retrieved successfully.',
            'data' => $profile->educations()->orderByDesc('start_date')->get(),
        ], 200);
    }

    public function storeEducation(StoreEducationRequest $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        $education = $profile->educations()->create($request->validated());

        return response()->json([
            'message' => 'Education created successfully.',
            'data' => $education,
        ], 201);
    }

    public function updateEducation(UpdateEducationRequest $request, int $id): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Only search within this candidate's education records
        $education = $profile->educations()->find($id);

        if (!$education) {
            return response()->json([
                'message' => 'Education record not found.',
            ], 404);
        }

        $education->update($request->validated());

        return response()->json([
            'message' => 'Education updated successfully.',
            'data' => $education->fresh(),
        ], 200);
    }

    public function deleteEducation( Request $request,int $id): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Only search within this candidate's education records
        $education = $profile->educations()->find($id);

        if (!$education) {
            return response()->json([
                'message' => 'Education record not found.',
            ], 404);
        }

        $education->delete();

        return response()->json([
            'message' => 'Education deleted successfully.',
        ], 200);
    }

    public function storeExperience(StoreExperienceRequest $request ): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        $experience = $profile->experiences()->create($request->validated());

        return response()->json([
            'message' => 'Experience created successfully.',
            'data' => $experience,
        ], 201);
    }

     public function indexExperience(Request $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Experience records retrieved successfully.',
            'data' => $profile->experiences()->orderByDesc('start_date')->get(),
        ], 200);
    }

    public function updateExperience(UpdateExperienceRequest $request, int $id): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Only search within this candidate's experience records
        $experience = $profile->experiences()->find($id);

        if (!$experience) {
            return response()->json([
                'message' => 'Experience record not found.',
            ], 404);
        }

        $experience->update($request->validated());

        return response()->json([
            'message' => 'Experience updated successfully.',
            'data' => $experience->fresh(),
        ], 200);
    }

    public function deleteExperience( Request $request,int $id): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Only search within this candidate's education records
        $experience = $profile->experiences()->find($id);

        if (!$experience) {
            return response()->json([
                'message' => 'Experience record not found.',
            ], 404);
        }

        $experience->delete();

        return response()->json([
            'message' => 'Experience deleted successfully.',
        ], 200);
    }

    public function indexSkills(Request $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Skills retrieved successfully.',
            'data' => $profile->skills()
                ->select('skills.id', 'skills.name')
                ->orderBy('skills.name')
                ->get(),
        ], 200);
    }

    public function storeSkills(StoreCandidateSkillsRequest $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        $skillIds = $request->validated()['skills'];

        // Add new skills, keep existing ones
        $profile->skills()->syncWithoutDetaching($skillIds);

        return response()->json([
            'message' => 'Skills added successfully.',
            'data' => $profile->skills()
                ->select('skills.id', 'skills.name')
                ->orderBy('skills.name')
                ->get(),
        ], 200);
    }

    public function updateSkills(StoreCandidateSkillsRequest $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        $skillIds = $request->validated()['skills'];

        // Replace all existing skills
        $profile->skills()->sync($skillIds);

        return response()->json([
            'message' => 'Skills updated successfully.',
            'data' => $profile->skills()
                ->select('skills.id', 'skills.name')
                ->orderBy('skills.name')
                ->get(),
        ], 200);
    }

    public function deleteSkill(Request $request,int $skillId): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        // Remove the relation from the pivot table
        $profile->skills()->detach($skillId);

        return response()->json([
            'message' => 'Skill removed successfully.',
        ], 200);
    }

    public function dashboard(Request $request): JsonResponse
    {
        $profile = $request->user()->candidateProfile;

        if (!$profile) {
            return response()->json([
                'message' => 'Candidate profile not found.',
            ], 404);
        }

        $educationCount = $profile->educations()->count();

        $experienceCount = $profile->experiences()->count();

        $skillsCount = $profile->skills()->count();

        $resumeUploaded = !empty($profile->resume_path);

        $avatarUploaded = !empty($profile->avatar_path);

        $profileCompletion = $this->calculateProfileCompletion($profile);

        return response()->json([
            'message' => 'Candidate dashboard retrieved successfully.',
            'data' => [
                'profile_completion' => $profileCompletion,
                'education_count' => $educationCount,
                'experience_count' => $experienceCount,
                'skills_count' => $skillsCount,
                'resume_uploaded' => $resumeUploaded,
                'avatar_uploaded' => $avatarUploaded,
            ],
        ], 200);

        }

    private function calculateProfileCompletion($profile): int
    {
        $totalFields = 8;

        $completedFields = 0;

        if (!empty($profile->phone)) {
            $completedFields++;
        }

        if (!empty($profile->country)) {
            $completedFields++;
        }

        if (!empty($profile->city)) {
            $completedFields++;
        }

        if (!empty($profile->headline)) {
            $completedFields++;
        }

        if (!empty($profile->bio)) {
            $completedFields++;
        }

        if (!empty($profile->resume_path)) {
            $completedFields++;
        }

        if (!empty($profile->avatar_path)) {
            $completedFields++;
        }

        if ($profile->skills()->exists()) {
            $completedFields++;
        }

        return (int) round(($completedFields / $totalFields) * 100);
    }
}

