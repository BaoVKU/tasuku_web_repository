<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    //
    public function index(Request $request)
    {
        $events = DB::table('tasks')
            ->select('tasks.title', 'tasks.start', 'tasks.end', 'groups.name as group')
            ->join('task_members', 'tasks.id', '=', 'task_members.task_id')
            ->leftJoin('groups', 'groups.id', '=', 'tasks.group_id')
            ->where('task_members.member_id', '=', auth()->user()->id)
            ->get();

        if ($request->expectsJson()) {
            return response()->json($events);
        }
        return view('calendar', ['events' => $events]);
    }
}
