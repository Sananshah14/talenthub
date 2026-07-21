<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'company_name',
        'job_title',
        'start_date',
        'end_date',
        'currently_working',
        'location',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'currently_working' => 'boolean',
        ];
    }

    public function candidateProfile()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
