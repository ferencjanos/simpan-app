<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        $activities = $query->paginate(15);
        return view('activity-log.index', compact('activities'));
    }
}