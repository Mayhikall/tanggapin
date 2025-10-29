<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $reports = $user->reports()->latest()->get();
        return view('dashboard', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pengaduan,aspirasi',
            'content' => 'required|string',
            'date_of_incident' => 'required|date|before_or_equal:today',
            'location_address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/reports', $filename);
            $validated['image'] = $filename;
        }

        $report = Report::create($validated);

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim dan sedang menunggu review.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        // Check if user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        // Check if user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        // Check if user owns this report and it's still pending
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($report->status !== 'pending') {
            return redirect()->route('reports.show', $report)
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pengaduan,aspirasi',
            'content' => 'required|string',
            'date_of_incident' => 'required|date|before_or_equal:today',
            'location_address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($report->image) {
                Storage::delete('public/reports/' . $report->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/reports', $filename);
            $validated['image'] = $filename;
        }

        $report->update($validated);

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // Check if user owns this report and it's still pending
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($report->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        // Delete image if exists
        if ($report->image) {
            Storage::delete('public/reports/' . $report->image);
        }

        $report->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus.');
    }
}
