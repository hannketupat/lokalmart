<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with(['reporter', 'product'])->latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report): View
    {
        $report->load('reporter', 'product');
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $report->update($request->only(['status']));

        return back()->with('success', 'Laporan berhasil diperbarui');
    }
}
