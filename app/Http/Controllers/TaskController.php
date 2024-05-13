<?php

namespace App\Http\Controllers;

use App\Events\NotifyEvent;
use App\Models\Group;
use App\Models\Notification;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TaskMember;
use App\Models\TaskOperation;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $task = DB::table('tasks')
            ->leftJoin('task_members', 'tasks.id', '=', 'task_members.task_id')
            ->join('users', 'users.id', '=', 'tasks.creator_id')
            ->select('tasks.id', 'tasks.creator_id as task_creator', 'users.name as creator_name', 'users.avatar as creator_avatar', 'group_id', 'mode', 'title', 'tasks.description', 'start', 'end', 'tasks.created_at')
            ->where('tasks.id', $request->task_id)
            ->groupBy('tasks.id', 'creator_id', 'name', 'avatar', 'group_id', 'mode', 'title', 'description', 'start', 'end', 'tasks.created_at')
            ->first();

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

        return response()->json([
            'task' => $task,
            'members' => $members,
            'attachments' => $attachments,
        ]);

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
        $request->validate([
            'mode' => ['required', 'in:0,1,2'],
            'start-day' => ['required', 'date'],
            'start-time' => ['required'],
            'end-day' => ['required', 'date', 'after:start'],
            'end-time' => ['required'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $groupID = $request->mode == 2 ? null : $request->input('group-id');

        $start = Carbon::parse($request->input('start-time') . ' ' . $request->input('start-day'))->toDateTimeString();
        $end = Carbon::parse($request->input('end-time') . ' ' . $request->input('end-day'))->toDateTimeString();

        $task = Task::create([
            'creator_id' => $request->user()->id,
            'group_id' => $groupID,
            'mode' => $request->mode,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $start,
            'end' => $end
        ]);

        if ($request->mode == 2) {
            TaskMember::create([
                'task_id' => $task->id,
                'member_id' => $request->user()->id
            ]);

            TaskOperation::create([
                'task_id' => $task->id,
                'user_id' => $request->user()->id
            ]);
        } else {
            if (!is_null($request->members))
                foreach ($request->members as $id) {
                    TaskMember::create([
                        'task_id' => $task->id,
                        'member_id' => $id
                    ]);

                    TaskOperation::create([
                        'task_id' => $task->id,
                        'user_id' => $id
                    ]);
                }
        }

        if ($request->hasFile('files'))
            foreach ($request->file('files') as $file) {
                $url = 'storage/' . $file->store('attachments/task', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
                $type = $file->getClientMimeType();

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'name' => $name,
                    'extension' => $extension,
                    'type' => $type,
                    'url' => $url
                ]);
            }
        ;
        if ($groupID) {
            $content = $request->user()->name . ' has created task';
            $taskMembers = TaskMember::where('task_id', $task->id)
                ->where('member_id', '<>', $request->user()->id)
                ->select('member_id as id')
                ->get();
            $group = Group::where('id', $groupID)->value('join_key');
            $url = 'workspace/group/' . $group;

            Notification::create([
                'creator_id' => $request->user()->id,
                'task_id' => $task->id,
                'content' => $content,
                'url' => $url
            ]);

            $date = Carbon::now()->format('H:i:s d/m/Y');
            event(new NotifyEvent($request->user()->id, $task->id, $taskMembers->toArray(), $date, $content, $task->title, $url));
        }

        return response()->json([
            'start' => $start,
            'end' => $end
        ]);
    }
    public function storeApi(Request $request)
    {
        $request->validate([
            'mode' => ['required', 'in:0,1,2'],
            'from' => ['required'],
            'start' => ['required'],
            'to' => ['required'],
            'end' => ['required'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $groupID = null;
        if ($request->mode != 2) {
            $group = Group::where('join_key', $request->groupId)->first();
            $groupID = $group->id;
        }

        $startFormat = Carbon::createFromFormat('H:i d/m/Y', $request->start . ' ' . $request->from)->format('Y-m-d H:i:s');
        $endFormat = Carbon::createFromFormat('H:i d/m/Y', $request->end . ' ' . $request->to)->format('Y-m-d H:i:s');

        $task = Task::create([
            'creator_id' => $request->user()->id,
            'group_id' => $groupID,
            'mode' => $request->mode,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $startFormat,
            'end' => $endFormat
        ]);

        if ($request->mode == 2) {
            TaskMember::create([
                'task_id' => $task->id,
                'member_id' => $request->user()->id
            ]);

            TaskOperation::create([
                'task_id' => $task->id,
                'user_id' => $request->user()->id
            ]);
        } else {
            if (!is_null($request->members)) {
                $memberIdList = explode(',', $request->members);
                foreach ($memberIdList as $id) {
                    TaskMember::create([
                        'task_id' => $task->id,
                        'member_id' => $id
                    ]);

                    TaskOperation::create([
                        'task_id' => $task->id,
                        'user_id' => $id
                    ]);
                }
            }
        }

        if ($request->hasFile('files'))
            foreach ($request->file('files') as $file) {
                $url = 'storage/' . $file->store('attachments/task', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
                $type = $file->getClientMimeType();

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'name' => $name,
                    'extension' => $extension,
                    'type' => $type,
                    'url' => $url
                ]);
            }

        if ($groupID) {
            $content = $request->user()->name . ' has created task';
            $taskMembers = TaskMember::where('task_id', $task->id)
                ->where('member_id', '<>', $request->user()->id)
                ->select('member_id as id')
                ->get();
            $group = Group::where('id', $groupID)->value('join_key');
            $url = 'workspace/group/' . $group;

            Notification::create([
                'creator_id' => $request->user()->id,
                'task_id' => $task->id,
                'content' => $content,
                'url' => $url
            ]);

            $date = Carbon::now()->format('H:i:s d/m/Y');
            event(new NotifyEvent($request->user()->id, $task->id, $taskMembers->toArray(), $date, $content, $task->title, $url));
        }
        return response()->json(true, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateApi(Request $request)
    {
        //
        $request->validate([
            'mode' => ['required', 'in:0,1,2'],
            'from' => ['required'],
            'start' => ['required'],
            'to' => ['required'],
            'end' => ['required'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $task = Task::find($request->taskId);
        $this->authorize('update', $task);

        $startFormat = Carbon::createFromFormat('H:i d/m/Y', $request->start . ' ' . $request->from)->format('Y-m-d H:i:s');
        $endFormat = Carbon::createFromFormat('H:i d/m/Y', $request->end . ' ' . $request->to)->format('Y-m-d H:i:s');

        $groupID = null;
        if ($request->mode != 2) {
            $group = Group::where('join_key', $request->groupId)->first();
            $groupID = $group->id;
        }

        $task->update([
            'mode' => $request->mode,
            'group_id' => $groupID,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $startFormat,
            'end' => $endFormat
        ]);

        if ($request->mode == 2) {
            TaskMember::where('task_id', $task->id)
                ->where('member_id', '!=', $request->user()->id)
                ->delete();
        } else if (!is_null($request->members)) {
            $taskMemberIds = explode(',', $request->members);

            $existingTaskMembers = DB::table('task_members')
                ->where('task_id', $task->id)
                ->pluck('member_id')
                ->toArray();

            $membersToAdd = array_diff($taskMemberIds, $existingTaskMembers);

            $membersToDelete = array_diff($existingTaskMembers, $taskMemberIds);

            foreach ($membersToAdd as $memberId) {
                TaskMember::create([
                    'task_id' => $task->id,
                    'member_id' => $memberId
                ]);

                TaskOperation::create([
                    'task_id' => $task->id,
                    'user_id' => $memberId
                ]);
            }

            if (!empty($membersToDelete)) {
                TaskMember::where('task_id', $task->id)
                    ->whereIn('member_id', $membersToDelete)
                    ->delete();

                TaskOperation::where('task_id', $task->id)
                    ->whereIn('user_id', $membersToDelete)
                    ->delete();
            }
        }

        if ($request->hasFile('files'))
            foreach ($request->file('files') as $file) {
                $url = 'storage/' . $file->store('attachments/task', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
                $type = $file->getClientMimeType();

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'name' => $name,
                    'extension' => $extension,
                    'type' => $type,
                    'url' => $url
                ]);
            }

        // if ($groupID) {
        //     $content = $request->user()->name . ' has updated task';
        //     $taskMembers = TaskMember::where('task_id', $task->id)
        //         ->where('member_id', '<>', $request->user()->id)
        //         ->select('member_id as id')
        //         ->get();
        //     $group = Group::where('id', $groupID)->value('join_key');
        //     $url = 'workspace/group/' . $group;

        //     Notification::create([
        //         'creator_id' => $request->user()->id,
        //         'task_id' => $task->id,
        //         'content' => $content,
        //         'url' => $url
        //     ]);

        //     $date = Carbon::now()->format('H:i:s d/m/Y');
        //     event(new NotifyEvent($request->user()->id, $task->id, $taskMembers->toArray(), $date, $content, $task->title, $url));
        // }
        return response()->json(true, 200);
    }
    public function update(Request $request)
    {
        //
        $request->validate([
            'mode' => ['required', 'in:0,1,2'],
            'start-day' => ['required', 'date'],
            'start-time' => ['required'],
            'end-day' => ['required', 'date', 'after:start'],
            'end-time' => ['required'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $task = Task::find($request->task_id);
        $this->authorize('update', $task);

        $start = Carbon::parse($request->input('start-time') . ' ' . $request->input('start-day'))->toDateTimeString();
        $end = Carbon::parse($request->input('end-time') . ' ' . $request->input('end-day'))->toDateTimeString();
        $groupID = $request->mode == 2 ? null : $request->input('group-id');

        $task->update([
            'mode' => $request->mode,
            'group_id' => $groupID,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $start,
            'end' => $end
        ]);

        if ($request->mode == 2) {
            if (is_null(TaskMember::firstWhere('member_id', $request->user()->id))) {
                TaskMember::create([
                    'task_id' => $task->id,
                    'member_id' => $request->user()->id
                ]);

                TaskOperation::create([
                    'task_id' => $task->id,
                    'user_id' => $request->user()->id
                ]);
            }
        } else {
            if (!is_null($request->members))
                foreach ($request->members as $id) {
                    if (is_null(TaskMember::firstWhere('member_id', $id))) {
                        TaskMember::create([
                            'task_id' => $task->id,
                            'member_id' => $id
                        ]);

                        TaskOperation::create([
                            'task_id' => $task->id,
                            'user_id' => $id
                        ]);
                    }
                }
        }

        if ($request->hasFile('files'))
            foreach ($request->file('files') as $file) {
                $url = 'storage/' . $file->store('attachments/task', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
                $type = $file->getClientMimeType();

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'name' => $name,
                    'extension' => $extension,
                    'type' => $type,
                    'url' => $url
                ]);
            }
        ;
        if ($groupID) {
            $content = $request->user()->name . ' has updated task';
            $taskMembers = TaskMember::where('task_id', $task->id)
                ->where('member_id', '<>', $request->user()->id)
                ->select('member_id as id')
                ->get();
            $group = Group::where('id', $groupID)->value('join_key');
            $url = 'workspace/group/' . $group;

            Notification::create([
                'creator_id' => $request->user()->id,
                'task_id' => $task->id,
                'content' => $content,
                'url' => $url
            ]);

            $date = Carbon::now()->format('H:i:s d/m/Y');
            event(new NotifyEvent($request->user()->id, $task->id, $taskMembers->toArray(), $date, $content, $task->title, $url));
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::find($id);

        $this->authorize('delete', $task);

        $task->delete();

        if ($request->expectsJson())
            return response()->json(true, 200);
        return response('Deleted');
    }

    public function destroyMember($id)
    {
        $taskMember = TaskMember::find($id);
        $task = Task::where('id', $taskMember->task_id)->first();

        $this->authorize('update', $task);

        $taskMember->delete();

        return response('Deleted');
    }

    public function destroyAttachment(Request $request, $id)
    {
        $taskAttachment = TaskAttachment::find($id);
        $task = Task::where('id', $taskAttachment->task_id)->first();

        $this->authorize('update', $task);

        $taskAttachment->delete();

        if ($request->expectsJson())
            return response()->json(true, 200);
        return response('Deleted');
    }

    public function search(Request $request)
    {
        if ($request->keyword) {
            $keyword = '%' . $request->keyword . '%';
            $groupID = $request->group_id ? $request->group_id : null;
            $users = DB::table('users')
                ->rightJoin('group_members', 'group_members.member_id', '=', 'users.id')
                ->select('users.id', 'users.name')
                ->where('group_members.group_id', $groupID)
                ->where('name', 'like', $keyword)
                ->get();

            return response()->json($users->toArray());
        }

        return response()->json(['error' => 'Does not receive any keyword']);
    }

    public function operate(Request $request)
    {
        $task = Task::where('id', $request->task_id)->first();

        $this->authorize('operate', $task);

        $operation = TaskOperation::where('task_id', $request->task_id)
            ->where('user_id', $request->user()->id)
            ->first();

        $content = "";
        if ($request->operation == 'done') {
            if (is_null($operation->is_completed)) {
                $operation->is_completed = 1;
                $content = $request->user()->name . ' has finished task';
            } else {
                $operation->is_completed = null;
                $content = $request->user()->name . ' is re-doing task';
            }
        } else if ($request->operation == 'important')
            $operation->is_important = is_null($operation->is_important) ? 1 : null;

        $operation->save();

        // $taskMembers = TaskMember::where('task_id', $task->id)
        //     ->where('member_id', '<>', $request->user()->id)
        //     ->select('member_id as id')
        //     ->get();
        // $taskMembers->push(['id' => $task->creator_id]);
        // $group = Group::where('id', $task->group_id)->value('join_key');
        // $url = 'workspace/group/' . $group;

        // Notification::create([
        //     'creator_id' => $request->user()->id,
        //     'task_id' => $task->id,
        //     'content' => $content,
        //     'url' => $url
        // ]);

        // $date = Carbon::now()->format('H:i:s d/m/Y');
        // event(new NotifyEvent($request->user()->id, $task->id, $taskMembers->toArray(), $date, $content, $task->title, $url));
        return response()->json($operation);
    }
}
