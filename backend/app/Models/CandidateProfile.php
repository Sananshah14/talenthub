<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',

'phone',

'date_of_birth',

'country',

'city',

'headline',

'bio',

'github_url',

'linkedin_url',

'portfolio_url',

'resume_path'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function educations(){
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'candidate_skills'
        );
    }
}
