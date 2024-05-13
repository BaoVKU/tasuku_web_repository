<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\MessageChannel;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $messages = DB::table('messages')
            ->select('messages.id as message_id', 'sender_id', 'message', 'name', 'extension', 'type', 'url', 'messages.created_at')
            ->leftJoin('message_attachments', 'messages.id', '=', 'message_attachments.message_id')
            ->where('channel_id', $id)
            ->orderBy('messages.created_at')
            ->get();
        return response()->json($messages->toArray());
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
        $message = Message::create([
            'channel_id' => $request->channel,
            'sender_id' => $request->from,
            'message' => $request->message
        ]);

        $messageAttachment = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $url = 'storage/' . $file->store('attachments/chat', 'public');
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
            $type = $file->getClientMimeType();

            $messageAttachment = MessageAttachment::create([
                'message_id' => $message->id,
                'name' => $name,
                'extension' => $extension,
                'type' => $type,
                'url' => $url
            ]);
        }

        $pusherFile = null;
        if (!is_null($messageAttachment)) {
            $pusherFile = $messageAttachment->toArray();
        }

        $broadCastingChannel = MessageChannel::find($request->channel);

        event(new ChatEvent($broadCastingChannel->name, $request->from, $message->message, $pusherFile));

        return response()->json($broadCastingChannel->toArray());
    }

    public function connect(Request $request)
    {
        $userID = $request->user()->id;
        $partnerID = $request->partner_id;

        $messageChannel = MessageChannel::where(function ($query) use ($userID, $partnerID) {
            $query->where('first_user_id', $userID)
                ->where('second_user_id', $partnerID);
        })
            ->orWhere(function ($query) use ($userID, $partnerID) {
                $query->where('first_user_id', $partnerID)
                    ->where('second_user_id', $userID);
            })->first();

        if (is_null($messageChannel)) {
            $name = 'user-' . $userID . '-and-user-' . $partnerID . '-channel';
            $messageChannel = MessageChannel::create([
                'first_user_id' => $userID,
                'second_user_id' => $partnerID,
                'name' => $name
            ]);
        }

        return response()->json($messageChannel->toArray());
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
    public function video($id = null)
    {
        $username = 'userId' . auth()->user()->id;
        $jwt = $this->getAccessToken($username);

        return view('video-call', ['jwt' => $jwt, 'calleeId' => $id]);
    }
}
