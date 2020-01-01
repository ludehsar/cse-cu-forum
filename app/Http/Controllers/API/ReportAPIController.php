<?php

namespace App\Http\Controllers\API;

use App\Models\Report;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class ReportAPIController extends Controller
{
    public function getAllReports()
    {
        return Datatables::of(Report::query())
            ->removeColumn('user_id')
            ->addColumn('created_by', function($report) {
                return $report->user->name;
            })
            ->addColumn('action', function ($report) {
                $attr = '<div class="btn-group text-center" role="group" aria-label="Second group">';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-report" data-id="' . $report->id . '"><i class="fa fa-trash"></i> Delete</a></div>';

                return $attr;
            })
            ->rawColumns(['created_by', 'action'])
            ->make(true);
    }

    public function addReport(Request $request)
    {
        $this->validate($request, [
            'description' => ['required'],
        ]);

        $user = auth('api')->user();

        $postId = null;
        $commentId = null;

        if (isset($request->post_id) && isset($request->comment_id)) return response(null, 422);
        else if (isset($request->post_id)) $postId = $request->post_id;
        else if (isset($request->comment_id)) $commentId = $request->comment_id;
        else return response(null, 422);
        
        Report::create([
            'user_id' => $user->id,
            'post_id' => $postId,
            'comment_id' => $commentId,
            'description' => $request->description,
        ]);

        return response(null, 201);
    }

    public function deleteReport($id)
    {
        $report = Report::findOrFail($id);

        if (auth('api')->user()->is_admin) {
            $report->delete();
        }

        return response(null, 200);
    }
}
