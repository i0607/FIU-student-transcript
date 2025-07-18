<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function transcripts() {
        return $this->hasMany(Transcript::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    
}
}