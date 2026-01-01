<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with all reports
     */
    public function dashboard(Request $request)
    {
        $query = Report::with('user')->latest();

        // Filter by type if provided
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(15);

        // For AJAX requests, return only the table partial
        if ($request->ajax()) {
            return view('admin.partials.reports-table', compact('reports'))->render();
        }

        return view('admin.dashboard', compact('reports'));
    }

    /**
     * Approve a report
     */
    public function approve(Report $report)
    {
        $report->update(['status' => 'approved']);

        // Create notification for the report owner
        Notification::create([
            'user_id' => $report->user_id,
            'report_id' => $report->id,
            'title' => 'Laporan Disetujui',
            'message' => "Laporan Anda dengan judul \"{$report->title}\" telah disetujui oleh admin.",
            'type' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }

    /**
     * Reject a report
     */
    public function reject(Report $report)
    {
        $report->update(['status' => 'rejected']);

        // Create notification for the report owner
        Notification::create([
            'user_id' => $report->user_id,
            'report_id' => $report->id,
            'title' => 'Laporan Ditolak',
            'message' => "Laporan Anda dengan judul \"{$report->title}\" telah ditolak oleh admin.",
            'type' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil ditolak.');
    }

    /**
     * Show detailed report view for admin
     */
    public function reportDetail(Report $report)
    {
        $report->load('user');
        return view('admin.report-detail', compact('report'));
    }

    /**
     * Display user management dashboard
     */
    public function userDashboard()
    {
        $users = \App\Models\User::paginate(10);
        return view('admin.dashboard-user', compact('users'));
    }

    /**
     * Display all user feedbacks
     */
    public function feedbacks()
    {
        $feedbacks = \App\Models\Feedback::with(['user', 'report'])
            ->latest()
            ->paginate(15);
        
        return view('admin.feedbacks', compact('feedbacks'));
    }

    /**
     * Display map with all reports
     */
    public function map()
    {
        return view('admin.map');
    }
}
