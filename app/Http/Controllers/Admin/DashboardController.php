<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Content;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $user->loadMissing('roleRelation.permissions');

        $role = $user->roleRelation;
        $isAdmin = $role?->name === 'admin';
        $roleLabel = $role?->label ?? 'Usuario';

        $hasPermission = function (string $permission) use ($user, $isAdmin): bool {
            if ($isAdmin) {
                return true;
            }

            return $user->roleRelation?->permissions?->contains('name', $permission) ?? false;
        };

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(6)
            ->get();

        $usersCount = User::count();
        $contentsCount = Content::count();
        $notificationsCount = Notification::count();
        $activitiesCount = ActivityLog::count();
        $todayActivities = ActivityLog::whereDate('created_at', today())->count();
        $unreadNotificationsCount = Notification::whereNull('read_at')->count();
        $publishedContentsCount = Content::where('status', 'published')->count();
        $newUsersToday = User::whereDate('created_at', today())->count();
        $usersLast7Days = User::where('created_at', '>=', now()->subDays(6)->startOfDay())->count();
        $activitiesLast7Days = ActivityLog::where('created_at', '>=', now()->subDays(6)->startOfDay())->count();

        $activityByDay = ActivityLog::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $activityChart = collect(range(6, 0))->map(function (int $daysAgo) use ($activityByDay): array {
            $date = now()->subDays($daysAgo)->startOfDay();
            $activity = $activityByDay->firstWhere('date', $date->format('Y-m-d'));

            return [
                'label' => $date->format('d/m'),
                'value' => (int) ($activity?->total ?? 0),
            ];
        });

        $chartMax = max(1, (int) $activityChart->max('value'));
        $chartPoints = $activityChart->values()->map(function (array $item, int $index) use ($activityChart, $chartMax): array {
            $width = 720;
            $height = 240;
            $paddingX = 24;
            $paddingY = 24;
            $usableWidth = $width - ($paddingX * 2);
            $usableHeight = $height - ($paddingY * 2);
            $steps = max(1, $activityChart->count() - 1);
            $x = $paddingX + ($index / $steps) * $usableWidth;
            $y = $height - $paddingY - ($item['value'] / $chartMax) * $usableHeight;

            return [
                'x' => round($x, 2),
                'y' => round($y, 2),
            ];
        });

        $chartPolyline = $chartPoints
            ->map(fn (array $point): string => $point['x'] . ',' . $point['y'])
            ->implode(' ');

        $firstPoint = $chartPoints->first();
        $lastPoint = $chartPoints->last();
        $areaPath = '';

        if ($firstPoint && $lastPoint) {
            $areaPath = 'M ' . $firstPoint['x'] . ' 264 L ' .
                $chartPoints->map(fn (array $point): string => $point['x'] . ' ' . $point['y'])->implode(' L ') .
                ' L ' . $lastPoint['x'] . ' 264 Z';
        }

        return view('dashboard', compact(
            'user',
            'roleLabel',
            'isAdmin',
            'hasPermission',
            'recentActivities',
            'usersCount',
            'contentsCount',
            'notificationsCount',
            'activitiesCount',
            'todayActivities',
            'unreadNotificationsCount',
            'publishedContentsCount',
            'newUsersToday',
            'usersLast7Days',
            'activitiesLast7Days',
            'activityChart',
            'chartPoints',
            'chartPolyline',
            'areaPath',
        ));
    }
}
