<?php

namespace App\Http\Controllers\Laa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Date Logic
        // Default: Last 14 days
        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))
            : Carbon::now()->subDays(13);

        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();

        // Ensure start is before end
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // 1. Stats Cards (Filtered by Range)
        $rangeQuery = Bap::whereBetween('created_at', [
            $startDate->format('Y-m-d 00:00:00'),
            $endDate->format('Y-m-d 23:59:59')
        ]);

        $totalBap = (clone $rangeQuery)->count();
        $verifiedBap = (clone $rangeQuery)->where('status', 'APPROVED')->count();
        $pendingBap = (clone $rangeQuery)->where('status', 'PENDING')->count();
        $rejectedBap = (clone $rangeQuery)->where('status', 'REJECTED')->count(); // Added for chart/logic

        // Percentages
        $verifiedPercent = $totalBap > 0 ? round(($verifiedBap / $totalBap) * 100) : 0;

        // 2. Chart Data
        $chartData = [];
        $dates = [];
        $pendingSeries = [];
        $approvedSeries = [];
        $rejectedSeries = [];

        // Query raw data grouped by date(created_at) and status
        $rawStats = Bap::select(
            DB::raw('DATE(created_at) as date'),
            'status',
            DB::raw('count(*) as count')
        )
            ->whereBetween('created_at', [$startDate->format('Y-m-d 00:00:00'), $endDate->format('Y-m-d 23:59:59')])
            ->groupBy('date', 'status')
            ->get();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $displayDate = $date->format('d M');
            $dates[] = $displayDate;

            $pCount = $rawStats->where('date', $dateString)->where('status', 'PENDING')->first()?->count ?? 0;
            $aCount = $rawStats->where('date', $dateString)->where('status', 'APPROVED')->first()?->count ?? 0;
            $rCount = $rawStats->where('date', $dateString)->where('status', 'REJECTED')->first()?->count ?? 0;

            $pendingSeries[] = $pCount;
            $approvedSeries[] = $aCount;
            $rejectedSeries[] = $rCount;
        }

        // 3. Recent Activities (All time mostly, or filtered? Usually 'Recent' means literally recent, irrespective of filter, but let's keep it simple: Latest 5)
        $recentActivities = Bap::with('user')->latest()->take(5)->get();

        // 4. Notifications
        $notifications = Bap::with('user')
            ->where('status', 'PENDING')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($bap) {
                return [
                    'id' => $bap->id,
                    'title' => 'BAP Baru Masuk',
                    'message' => $bap->mata_kuliah . ' oleh ' . ($bap->user->name ?? $bap->pengawas_1),
                    'time' => $bap->created_at->diffForHumans(),
                    'is_read' => false
                ];
            });

        return view('laa.dashboard', compact(
            'totalBap',
            'verifiedBap',
            'pendingBap',
            'verifiedPercent',
            'dates',
            'pendingSeries',
            'approvedSeries',
            'rejectedSeries',
            'recentActivities',
            'notifications',
            'startDate',
            'endDate'
        ));
    }
}
