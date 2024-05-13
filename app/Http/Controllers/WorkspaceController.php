<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkspaceController extends Controller
{
    //
    public function index(Request $request)
    {
        $tasks = DB::table('tasks')
            ->leftJoin('task_members', 'tasks.id', '=', 'task_members.task_id')
            ->join('users', 'users.id', '=', 'tasks.creator_id')
            ->select('tasks.id', 'tasks.creator_id as task_creator', 'users.name as creator_name', 'users.avatar as creator_avatar', 'group_id', 'mode', 'title', 'tasks.description', 'start', 'end', 'tasks.created_at')
            ->where('tasks.mode', 2)
            ->where('creator_id', auth()->user()->id)
            ->groupBy('tasks.id', 'creator_id', 'name', 'avatar', 'group_id', 'mode', 'title', 'description', 'start', 'end', 'tasks.created_at')
            ->get();
        $merged = collect();
        foreach ($tasks as $task) {
            $members = DB::table('task_members')
                ->select('users.id', 'users.name', 'task_members.id as task_members_id', 'avatar', 'is_completed', 'is_important')
                ->join('users', 'users.id', '=', 'task_members.member_id')
                ->join('task_operations', function (JoinClause $join) {
                    $join->on('task_operations.task_id', '=', 'task_members.task_id')
                        ->whereColumn('task_operations.user_id', 'task_members.member_id');
                })
                ->where('task_members.task_id', '=', $task->id)
                ->get();

            $attachments = DB::table('task_attachments')
                ->join('tasks', 'tasks.id', '=', 'task_attachments.task_id')
                ->select('task_attachments.id as attachment_id', 'name', 'extension', 'type', 'url')
                ->where('tasks.id', $task->id)
                ->get();


            $merged->push([
                'task' => $task,
                'members' => $members,
                'attachments' => $attachments,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json($merged);
        }

        return view('workspace', ['tasks' => $merged]);
    }
}
