<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display the public map with all approved reports.
     */
    public function index()
    {
        return view('map.index');
    }

    /**
     * Get all reports for map (JSON API).
     * Both admin and public can see all reports with status filter.
     */
    public function getReports(Request $request)
    {
        $query = Report::with(['user:id,name', 'feedback'])
            ->select(['id', 'user_id', 'title', 'type', 'location_address', 'latitude', 'longitude', 'status', 'created_at']);

        // Filter by status if provided (for both admin and public)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type if provided
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $reports = $query->get()->map(function ($report) {
            // Status label in Indonesian
            $statusLabels = [
                'pending' => 'Direview',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
            ];

            return [
                'id' => $report->id,
                'title' => $report->title,
                'type' => $report->type,
                'type_label' => $report->type === 'pengaduan' ? 'Pengaduan' : 'Aspirasi',
                'status' => $report->status,
                'status_label' => $statusLabels[$report->status] ?? $report->status,
                'location_address' => $report->location_address,
                'latitude' => (float) $report->latitude,
                'longitude' => (float) $report->longitude,
                'user_name' => $report->user->name ?? 'Anonymous',
                'created_at' => $report->created_at->format('d M Y'),
                'rating' => $report->feedback ? $report->feedback->rating : null,
                'comment' => $report->feedback ? $report->feedback->comment : null,
            ];
        });

        return response()->json($reports);
    }
}
