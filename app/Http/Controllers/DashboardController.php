<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use App\Models\Publication;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'usuario' => auth()->user(),
            'publicationsCount' => Publication::count(),
            'publishedCount' => Publication::publiclyVisible()->count(),
            'draftsCount' => Publication::query()->where('status', 'draft')->count(),
            'evidencesCount' => Evidence::count(),
        ]);
    }
}
