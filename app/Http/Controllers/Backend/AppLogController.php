<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use Illuminate\Http\Request;

class AppLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = AppLog::with('user')
            ->latest()
            ->paginate(20);

        return view('backend.app-logs.index', compact('logs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AppLog $app_log)
    {
        $app_log->load('user');
        return view('backend.app-logs.show', compact('app_log'));
    }
}
