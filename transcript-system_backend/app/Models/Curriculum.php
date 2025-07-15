<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'course_id',
        'department_id', 
        'faculty_id',
        'version',
        'semester',
        'course_category',
        'total_credits',
        'ects',
        'lecture_hours',
        'lab_hours', 
        'tutorial',
        'pre_requisite'
    ];

    /**
     * Get the course that belongs to this curriculum entry
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the department that owns this curriculum
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the faculty that owns this curriculum
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}