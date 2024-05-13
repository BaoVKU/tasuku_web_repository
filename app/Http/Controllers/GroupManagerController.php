<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupManagerController extends Controller
{
    //
    public function index()
    {
        $groups = Group::where('creator_id', auth()->user()->id)->get();
        return view('group-manager', ['groups' => $groups]);
    }
    public function show($id)
    {
        $groups = Group::where('creator_id', auth()->user()->id)->get();
        $curGroup = Group::where('join_key', $id)->first();
        $this->authorize('edit', $curGroup);
        $members = DB::table('users')
            ->select('group_members.id', 'member_id', 'users.name', 'email', 'avatar', 'group_members.created_at')
            ->join('group_members', 'group_members.member_id', '=', 'users.id')
            ->where('group_members.group_id', '=', $curGroup->id)
            ->where('member_id', '<>', auth()->user()->id)
            ->paginate(5);
        $totalTasks = Task::where('group_id', $curGroup->id)->get()->count();
        $totalMembers = GroupMember::where('group_id', $curGroup->id)->get()->count();
        return view('group-manager', ['groups' => $groups, 'curGroup' => $curGroup, 'members' => $members, 'totalMembers' => $totalMembers, 'totalTasks' => $totalTasks]);
    }
    public function update(Request $request)
    {
        $group = Group::find($request->id);
        $this->authorize('update', $group);
        $group->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return back();
    }
    public function kick($gID, $mID)
    {
        $group = Group::find($gID);
        $this->authorize('delete', $group);
        GroupMember::destroy($mID);
        return back();
    }
    public function destroy($id)
    {
        $group = Group::find($id);
        $this->authorize('delete', $group);
        $group->delete();
        return redirect()->route('group-manager.index');
    }
}
