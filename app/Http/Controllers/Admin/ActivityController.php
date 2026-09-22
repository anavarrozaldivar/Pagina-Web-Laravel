<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::query()
            ->with('user')
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->string('search'));

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhere('action', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date('date'));
        }

        $activities = $query
            ->paginate(15)
            ->withQueryString();

        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $actions = ActivityLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $activityStats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'thisWeek' => ActivityLog::where('created_at', '>=', now()->startOfWeek())->count(),
            'activeUsers' => ActivityLog::where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count('user_id'),
        ];

        return view('admin.activity.index', compact(
            'activities',
            'users',
            'actions',
            'activityStats'
        ));
    }

    public function show(ActivityLog $activity): View
    {
        $activity->load('user');

        return view('admin.activity.show', compact('activity'));
    }
}
