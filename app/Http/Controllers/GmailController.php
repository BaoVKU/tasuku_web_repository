<?php

namespace App\Http\Controllers;

use App\Mail\Gmail;
use Illuminate\Http\Request;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GmailController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'mail-to' => ['required', 'string'],
            'mail-subject' => ['required', 'string'],
            'mail-content' => ['required', 'string'],
        ]);
        $mailAddresses = preg_split('/\s*,\s*/', $request->input('mail-to'), -1, PREG_SPLIT_NO_EMPTY);
        $data = [
            'content' => $request->input('mail-content')
        ];
        $attachmentsPath = [];
        $urls = [];
        if ($request->hasFile('mail_file'))
            foreach ($request->file('mail_file') as $file) {
                $url = 'storage/' . $file->store('attachments/mail', 'public');
                $attachmentsPath[] = public_path($url);
                $urls[] = str_replace('storage/', '', $url);
            }
        Mail::cc($mailAddresses)
            ->send(new Gmail($request->user()->email, $request->input('mail-subject'), $data, $attachmentsPath));
        foreach ($urls as $url) {
            if (Storage::exists($url)) {
                Storage::delete($url);
            }
        }
        return back();
    }
}
