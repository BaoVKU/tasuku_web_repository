<?php

namespace App\Http\Controllers;

use App\Events\OnlineEvent;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use App\Services\UserActivityService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function show(Request $request)
    {
        $groups = DB::table('groups')
            ->join('group_members as gm1', 'groups.id', '=', 'gm1.group_id')
            ->join('group_members as gm2', 'groups.id', '=', 'gm2.group_id')
            ->select('groups.id', 'creator_id', 'name', 'description', 'join_key', 'groups.created_at', DB::raw('count(gm2.member_id) as member_count'))
            ->where('gm1.member_id', '=', $request->user()->id)
            ->groupBy('groups.id', 'creator_id', 'name', 'description', 'join_key', 'groups.created_at')
            ->get();

        return response()->json($groups);
    }

    public function index(Request $request, $id)
    {
        // $group = Group::where('join_key', $id)->first();

        $group = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->where('groups.join_key', $id)
            ->select('groups.id', 'creator_id', 'name', 'description', 'join_key', 'groups.created_at', DB::raw('count(group_members.member_id) as member_count'))
            ->groupBy('groups.id', 'creator_id', 'name', 'description', 'join_key', 'groups.created_at')
            ->first();

        $authorizeGroup = Group::where('join_key', $id)->first();
        $this->authorize('view', $authorizeGroup);

        $userID = $request->user()->id;
        $groupID = $group->id;

        $groupMembers = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->join('users', 'users.id', '=', 'group_members.member_id')
            ->select('users.id', 'users.name', 'users.avatar')
            ->where([
                ['groups.join_key', '=', $id],
                ['users.id', '<>', $userID]
            ])
            ->get();

        $tasks = DB::table('tasks')
            ->leftJoin('task_members', 'tasks.id', '=', 'task_members.task_id')
            ->join('users', 'users.id', '=', 'tasks.creator_id')
            ->leftJoin('groups', 'groups.id', '=', 'tasks.group_id')
            ->select('tasks.id', 'tasks.creator_id as task_creator', 'users.name as creator_name', 'users.avatar as creator_avatar', 'group_id', 'mode', 'title', 'tasks.description', 'start', 'end', 'tasks.created_at')
            ->where(function ($query) use ($userID) {
                $query->where('mode', 2)
                    ->where('tasks.creator_id', $userID);
            })
            ->orWhere(function ($query) use ($userID, $groupID) {
                $query->where('group_id', $groupID)
                    ->where(function ($query) use ($userID) {
                        $query->where('tasks.creator_id', $userID)
                            ->orWhere('mode', 0)
                            ->orWhere('member_id', $userID)
                            ->orWhere('groups.creator_id', $userID);
                    });
            })
            ->groupBy('tasks.id', 'tasks.creator_id', 'users.name', 'avatar', 'group_id', 'mode', 'title', 'description', 'start', 'end', 'tasks.created_at')
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
        if ($request->expectsJson())
            return response()->json(['group' => $group, "tasks" => $merged]);
        return view('workspace', ['group' => $group, 'groupMembers' => $groupMembers, 'tasks' => $merged]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);
        $latestGroup = Group::latest()->first();
        if ($latestGroup)
            $groupID = $latestGroup->id + 1;
        else
            $groupID = 1;
        $group = Group::create([
            'creator_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'join_key' => sha1($groupID)
        ]);
        GroupMember::create([
            'group_id' => $groupID,
            'member_id' => $request->user()->id,
        ]);
        if ($request->expectsJson())
            return response()->json(true, 200);
        return response()->json($group->toArray());
    }

    public function join(Request $request)
    {

        if ($request->expectsJson())
            $joinKey = $request->joinKey;
        else {
            $request->validate([
                'join-key' => ['required', 'string']
            ]);
            $joinKey = $request->input('join-key');
        }
        $group = Group::where('join_key', $joinKey)->first();
        if ($group) {
            $isJoined = GroupMember::where([
                ['group_id', '=', $group->id],
                ['member_id', '=', $request->user()->id]
            ])->first();
            if ($isJoined)
                $responseText = 'You have already joined this group';
            else {
                GroupMember::create([
                    'group_id' => $group->id,
                    'member_id' => $request->user()->id,
                ]);
                if ($request->expectsJson())
                    $responseText = 'You have successfully joined the group';
                else
                    return response()->json($group->toArray());
            }
        } else
            $responseText = 'Group does not exist';
        return response()->json([
            'responseText' => $responseText
        ]);
    }

    public function getMembers(Request $request, $id)
    {
        $groupMembers = DB::table('group_members')
            ->join('groups', 'group_members.group_id', '=', 'groups.id')
            ->join('users', 'group_members.member_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.avatar', 'group_members.id as group_member_id')
            ->where('groups.join_key', '=', $id)
            ->get();
        return response()->json($groupMembers);
    }

    public function leave(Request $request, $id)
    {
        $groupMember = GroupMember::where([
            ['group_id', '=', $id],
            ['member_id', '=', $request->user()->id]
        ])->first();
        if ($groupMember) {
            $groupMember->delete();
            return response()->json(true, 200);
        }
        return response()->json(false, 404);
    }

    public function information(Request $request, $id)
    {
        $group = Group::where('join_key', $id)->first();
        $groupMembers = DB::table('group_members')
            ->join('users', 'group_members.member_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.avatar')
            ->where('group_members.group_id', $group->id)
            ->get();
        return response()->json(['group' => $group, 'members' => $groupMembers]);
    }
}
