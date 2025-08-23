<?php

namespace App\Models\programs;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'code',
        'duration_years',
        'total_semesters',
        'total_subjects',
        'description',
    ];
}
