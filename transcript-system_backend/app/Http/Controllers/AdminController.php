<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Transcript;

class AdminController extends Controller
{
    public function dashboardStats()
    {
        $staffCount = User::where('role', 'staff')->count();
        $studentCount = Student::count();
        $courseCount = Course::count();
        $transcriptCount = Transcript::count();

        return response()->json([
            'staffCount' => $staffCount,
            'studentCount' => $studentCount,
            'courseCount' => $courseCount,
            'transcriptCount' => $transcriptCount,
        ]);
    }
    public function recentData()
    {
        $recentStaff = User::where('role', 'staff')->latest()->take(5)->get(['id', 'email', 'created_at']);
        $recentTranscripts = Transcript::latest()->take(5)->with('student')->get();

        return response()->json([
            'recentStaff' => $recentStaff,
            'recentTranscripts' => $recentTranscripts,
        ]);
    }

}
