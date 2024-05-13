<?php

namespace App\Http\Controllers;

use App\Models\CommentAttachment;
use App\Models\TaskComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TaskCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $comments = DB::table('task_comments')
            ->join('tasks', 'tasks.id', '=', 'task_comments.task_id')
            ->join('users', 'users.id', '=', 'task_comments.user_id')
            ->select('task_comments.id', 'user_id', 'name', 'avatar', 'comment', 'task_comments.created_at')
            ->where('task_comments.task_id', $request->task_id)
            ->orderByDesc('task_comments.created_at')
            ->get();
        $merged = collect();
        foreach ($comments as $comment) {
            $comment->created_at = Carbon::parse($comment->created_at)->format('H:i:s d/m/Y');
            $cmtAttachments = DB::table('comment_attachments')
                ->join('task_comments', 'task_comments.id', '=', 'comment_attachments.comment_id')
                ->select('comment_attachments.id as attachment_id', 'name', 'extension', 'type', 'url')
                ->where('comment_id', $comment->id)
                ->get();
            $merged->push([
                'comment' => $comment,
                'attachments' => $cmtAttachments
            ]);
        }
        return response()->json($merged);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // return redirect('console')->with('res', json_encode($request->all()));
        // $request->validate([
        //     'task_id' => ['required'],
        //     'comment' => ['required', 'string']
        // ]);
        $comment = TaskComment::create([
            'user_id' => $request->user()->id,
            'task_id' => $request->task_id,
            'comment' => $request->comment
        ]);
        $merged = collect();
        $attachments = collect();
        if ($request->hasFile('files'))
            foreach ($request->file('files') as $file) {
                $url = 'storage/' . $file->store('attachments/comment', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
                $type = $file->getClientMimeType();
                $attachment = CommentAttachment::create([
                    'comment_id' => $comment->id,
                    'name' => $name,
                    'extension' => $extension,
                    'type' => $type,
                    'url' => $url
                ]);
                $attachments->push($attachment);
            }

        // $merged->push($comment, $attachments);
        if ($request->expectsJson())
            return response()->json(true, 200);
        return response()->json([$comment, $attachments]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskComment $taskComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskComment $taskComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskComment $taskComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        $taskComment = TaskComment::find($id);

        // Gate::authorize('delete-task-comment', $taskComment);

        $taskComment->delete();

        if ($request->expectsJson())
            return response()->json(true, 200);
        return response('Deleted');
    }
}
