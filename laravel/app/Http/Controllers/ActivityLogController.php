<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    //
    public function index(Request $request)
    {
        $logs = ActivityLog::query();

        // Filter data berdasarkan jenis aktivitas dan kata kunci pencarian
        if ($request->has('activity') && $request->activity != '') {
            $logs->where('activity', $request->activity);
        }

        if ($request->has('search') && $request->search != '') {
            $logs->where('description', 'like', '%'.$request->search.'%');
        }

        $logs = $logs->orderBy('created_at', 'desc')->paginate(10);

        return view('activity-logs.index', 
            [
                'logs' => $logs,
                'title' => 'Activity Logs',
            ]
        );
    }
}
