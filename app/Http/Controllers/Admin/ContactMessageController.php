<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::orderByDesc('created_at');

        if ($request->filled('status') && in_array($request->status, array_keys(ContactMessage::statusOptions()))) {
            $query->where('status', $request->status);
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contact_message): View
    {
        if ($contact_message->status === ContactMessage::STATUS_NEW) {
            $contact_message->update(['status' => ContactMessage::STATUS_READ]);
        }

        return view('admin.contact-messages.show', ['contact' => $contact_message]);
    }

    public function update(Request $request, ContactMessage $contact_message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied,archived',
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $contact_message->status = $validated['status'];
        $contact_message->admin_notes = $validated['admin_notes'] ?? null;

        if ($validated['status'] === ContactMessage::STATUS_REPLIED && ! $contact_message->replied_at) {
            $contact_message->replied_at = now();
        }

        $contact_message->save();

        return redirect()->route('admin.contact-messages.show', $contact_message)->with('success', 'Contact updated.');
    }
}
