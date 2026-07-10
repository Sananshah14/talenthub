<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    //
    use HasFactory;
    protected $fillable =[
        'name',
        'email',
        'phone',
        'website',
        'logo_path',
        'industry',
        'company_size',
        'country',
        'city',
        'address',
        'description',
        'status',
    ];
     public function employerProfiles()
    {
        return $this->hasMany(EmployerProfile::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);//a company has many job listing
    }
}
