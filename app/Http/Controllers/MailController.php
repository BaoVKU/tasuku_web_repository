<?php

namespace App\Http\Controllers;

use App\Mail\Gmail;
use App\Models\Email;
use App\Models\EmailAttachment;
use App\Models\EmailReceiver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function index()
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
    public function store(Request $request)
    {
        $request->validate([
            'mail-to' => ['required', 'string'],
            'mail-subject' => ['required', 'string'],
            'mail-content' => ['required', 'string'],
        ]);
        $mailAddresses = preg_split('/\s*,\s*/', $request->input('mail-to'), -1, PREG_SPLIT_NO_EMPTY);
        $email = Email::create([
            'sender_id' => $request->user()->id,
            'title' => $request->input('mail-subject'),
            'description' => $request->input('mail-content')
        ]);
        foreach ($mailAddresses as $mailAddress) {
            $userID = User::where('email', $mailAddress)
                ->where('email', '<>', $request->user()->email)
                ->value('id');
            if ($userID)
                EmailReceiver::create([
                    'email_id' => $email->id,
                    'receiver_id' => $userID
                ]);
        }
        if ($request->hasFile('mail_file'))
            foreach ($request->file('mail_file') as $file) {
                $url = 'storage/' . $file->store('attachments/mail', 'public');
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo(basename($url), PATHINFO_EXTENSION);
                $type = $file->getClientMimeType();

                EmailAttachment::create([
                    'email_id' => $email->id,
                    'name' => $name,
                    'extension' => $extension,
                    'type' => $type,
                    'url' => $url
                ]);
            }

        return view('console', ['response' => $request->file('mail_file')]);
    }
    public function destroy($id)
    {
        $email = Email::find($id);
        $this->authorize('delete', $email);
        $email->delete();
        return response('Deleted');
    }
}
