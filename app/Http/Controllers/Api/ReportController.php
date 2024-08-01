<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // protected $fillable = [
    //     'report_date',
    //     'unit',
    //     'code',
    //     'name',
    //     'procurement_date',
    //     'username',
    //     'condition',
    // ];

    public function index()
    {
        $reports = Report::all();
        return response()->json([
            'message' => 'successfully get reports',
            'data' => $reports
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'procurement_date' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
        ]);

        $report = Report::create($request->all());
        return response()->json([
            'message' => 'successfully added report',
            'data' => $report
        ]);
    }

    public function show($id)
    {
        $report = Report::find($id);
        return response()->json([
            'message' => 'successfully get report',
            'data' => $report
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'report_date' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'procurement_date' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
        ]);

        $report = Report::find($id);
        if ($report == null) {
            return response()->json([
                'message' => 'report not found'
            ], 404);
        }
        $report->update($request->all());
        return response()->json([
            'message' => 'successfully updated report',
            'data' => $report
        ]);
    }

    public function destroy($id)
    {
        $report = Report::find($id);
        if ($report == null) {
            return response()->json([
                'message' => 'report not found'
            ], 404);
        }
        $report->delete();
        return response()->json([
            'message' => 'successfully deleted report'
        ]);
    }
}
