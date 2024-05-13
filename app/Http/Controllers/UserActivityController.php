<?php

namespace App\Http\Controllers;

use App\Events\OnlineEvent;
use App\Services\UserActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserActivityController extends Controller
{
    //
    protected $userActivityService;
    public function __construct(UserActivityService $userActivityService)
    {
        $this->userActivityService = $userActivityService;
    }
    public function connect($id)
    {
        $this->userActivityService->connect($id);
    }
    public function disconnect(Request $request)
    {
        $this->userActivityService->disconnect($request->id);
    }

}
