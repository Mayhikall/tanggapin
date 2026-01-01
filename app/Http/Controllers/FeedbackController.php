<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Store a new feedback for a report.
     */
    public function store(Request $request, Report $report)
    {
        // Ensure user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Anda tidak dapat memberikan feedback untuk laporan ini.');
        }

        // Ensure report is approved
        if ($report->status !== 'approved') {
            return redirect()->back()->with('error', 'Feedback hanya dapat diberikan untuk laporan yang sudah disetujui.');
        }

        // Ensure no existing feedback
        if ($report->hasFeedback()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan feedback untuk laporan ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'report_id' => $report->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Feedback Anda telah dikirim.');
    }
}
