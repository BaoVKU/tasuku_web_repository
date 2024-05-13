<?php

namespace App\View\Composers;

use App\Models\EmailAttachment;
use App\Models\Message;
use App\Models\MessageChannel;
use App\Services\UserActivityService;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ViewComposer
{
    protected $userActivityService;
    public function __construct(UserActivityService $userActivityService)
    {
        $this->userActivityService = $userActivityService;
    }
    private function getMailList()
    {
        $mails = DB::table('emails')
            ->select('emails.id', 'emails.sender_id', 'emails.title', 'emails.description', 'emails.created_at')
            ->join('email_receivers', 'email_receivers.email_id', '=', 'emails.id')
            ->where('emails.sender_id', '=', auth()->user()->id)
            ->orWhere('email_receivers.receiver_id', '=', auth()->user()->id)
            ->groupBy('emails.id', 'emails.sender_id', 'emails.title', 'emails.description', 'emails.created_at')
            ->get();
        $merged = collect();
        foreach ($mails as $mail) {
            $receivers = DB::table('users')
                ->join('email_receivers', 'email_receivers.receiver_id', '=', 'users.id')
                ->select('users.id', 'email')
                ->where('email_id', $mail->id)
                ->get();

            $attachments = EmailAttachment::where('email_id', $mail->id)->get();

            $merged->push([
                'mail' => $mail,
                'receivers' => $receivers,
                'attachments' => $attachments
            ]);
        }
        return $merged;
    }
    private function getChatList()
    {
        $userID = auth()->user()->id;
        $list = DB::table('message_channels')
            ->select('message_channels.id as channel_id', 'users.id as partner_id', 'message_channels.name as channel_name', 'users.name as partner_name', 'avatar')
            ->join('users', function (JoinClause $join) {
                $join->on('users.id', 'first_user_id')
                    ->orOn('users.id', 'second_user_id');
            })
            ->where(function ($query) use ($userID) {
                $query->where(function ($query) use ($userID) {
                    $query->where('first_user_id', $userID)
                        ->orWhere('second_user_id', $userID);
                })
                    ->where('users.id', '<>', $userID);
            })
            ->get();

        $merged = collect();
        foreach ($list as $item) {
            $lastMessage = DB::table('messages')
                ->select('message_id', 'message', 'name', 'extension', 'type', 'url', 'messages.created_at')
                ->leftJoin('message_attachments', 'messages.id', '=', 'message_attachments.message_id')
                ->where('channel_id', $item->channel_id)
                ->orderByDesc('messages.created_at')
                ->first();

            if ($lastMessage)
                $lastMessage->created_at = Carbon::parse($lastMessage->created_at)->diffForHumans();

            $merged->push([
                'chat_partner' => $item,
                'last_message' => is_null($lastMessage) ? null : $lastMessage
            ]);
        }
        return $merged;
    }
    private function getNotificationList()
    {
        $userID = auth()->user()->id;
        $notifications = DB::table('notifications')
            ->join('task_members', 'task_members.task_id', '=', 'notifications.task_id')
            ->join('tasks', 'tasks.id', '=', 'notifications.task_id')
            ->where('notifications.creator_id', '<>', $userID)
            ->where(function ($query) use ($userID) {
                $query->where('tasks.creator_id', $userID)
                    ->orWhere('task_members.member_id', $userID);
            })
            ->select('content', 'url', 'notifications.created_at', 'tasks.title')
            ->orderByDesc('notifications.created_at')
            ->get();
        foreach ($notifications as $notification) {
            $notification->created_at = Carbon::parse($notification->created_at)->format('H:i:s d/m/Y');
        }
        return $notifications;
    }
    private function getJoinedGroups()
    {
        $groups = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->where('member_id', '=', auth()->user()->id)
            ->get();
        return $groups;
    }
    private function getAccessToken($username)
    {
        $key = 'SK.0.iJclWdTI1L7sQW4JQrWPSp1AGouVXl7';
        $secret_key = "ZUNLVjJOTGtvSXFxZE9CdW1rZE1JTjdxR21kaUpES2o=";

        $now = time();
        $exp = $now + 3600 * 2;

        $header = array('cty' => "stringee-api;v=1");
        $payload = array(
            "jti" => $key . "-" . $now,
            "iss" => $key,
            "exp" => $exp,
            "userId" => $username
        );

        $jwt = JWT::encode($payload, $secret_key, 'HS256', null, $header);
        return $jwt;
    }
    public function compose(View $view): void
    {
        $view->with([
            'currentOnlineUsers' => $this->userActivityService->connect(auth()->user()->id),
            'joinedGroups' => $this->getJoinedGroups(),
            'chatList' => $this->getChatList(),
            'mailList' => $this->getMailList(),
            'notifications' => $this->getNotificationList(),
            'jwt' => $this->getAccessToken('userId' . auth()->user()->id)
        ]);
    }
}
