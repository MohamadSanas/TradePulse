<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $supportAddress = config('services.support.contact_email', 'sanasweb1@gmail.com');

        Mail::raw(
            "New support contact submission\n\n"
            ."Name: {$validated['name']}\n"
            ."Email: {$validated['email']}\n"
            ."Subject: {$validated['subject']}\n\n"
            ."Message:\n{$validated['message']}",
            function ($message) use ($validated, $supportAddress): void {
                $message
                    ->to($supportAddress)
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject('TradePulse Support: '.$validated['subject']);
            }
        );

        return back()->with('success', 'Your message has been sent successfully.');
    }
}
