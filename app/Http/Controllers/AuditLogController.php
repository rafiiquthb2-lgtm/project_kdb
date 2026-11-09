<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest('created_at');

        // Filter by table name
        if ($request->filled('table_name')) {
            $query->forTable($request->table_name);
        }

        // Filter by event type
        if ($request->filled('event_type')) {
            $query->byEventType($request->event_type);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        $logs = $query->paginate(20)->appends($request->query());

        return view('audit.index', compact('logs'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');
        return view('audit.show', compact('auditLog'));
    }
}
