<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
        ]);

        $contact = ContactMessage::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
        ]);

        $to = SiteSetting::get('contact_email', config('mail.from.address'));
        $name = $contact->full_name;
        $body = "Name: {$name}\nEmail: {$contact->email}\nPhone: " . ($contact->phone ?? 'N/A') . "\n\nMessage:\n{$contact->message}";

        try {
            \Illuminate\Support\Facades\Mail::raw($body, function ($message) use ($to, $contact) {
                $message->to($to)
                    ->subject('Website contact: ' . $contact->full_name)
                    ->replyTo($contact->email);
            });
        } catch (\Throwable $e) {
            // Message is saved; email failure is non-fatal
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! We have received your message and will get back to you soon.',
            ], 201);
        }

        return redirect()->to(route('home') . '#contact')->with('success', 'Thank you! We have received your message and will get back to you soon.');
    }
}
