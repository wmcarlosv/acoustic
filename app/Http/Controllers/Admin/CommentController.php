<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Gate;
use DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Notification;
use App\Models\AllReport;

class CommentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $comments = Comment::with('user')->orderBy('id','desc')->get();
        return view('admin.comment.commentTable', compact('comments'));
    }

    public function show(Comment $comment)
    {
        //
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $comment = Comment::find($id);
        $not = Notification::where('comment_id',$id)->get()->each->delete();
        $allReport = AllReport::where([['type','Comment'],['comment_id',$id]])->get()->each->delete();
        $likes = $comment->likes()->withType(Comment::class)->get()->each->delete();
        $comment->delete();
        return response()->json(['success' => true, 'msg' => __('Comment Deleted Successfully.')], 200);
    }

    public function reports_index()
    {
        abort_if(Gate::denies('comment_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $reports = AllReport::where('type','Comment')->groupBy('comment_id')->select('comment_id', DB::raw('count(*) as total'))->get();
        return view('admin.comment.comment_reportTable', compact('reports'));
    }
}
