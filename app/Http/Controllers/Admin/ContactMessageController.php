<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()
            ->when(request('q'), function ($query, $q) {
                $query->where(function ($nested) use ($q) {
                    $nested->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('subject', 'like', "%{$q}%")
                        ->orWhere('message', 'like', "%{$q}%");
                });
            })
            ->when(request('status'), fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contact-messages.index', [
            'messages' => $messages,
            'statuses' => ContactMessage::statuses(),
        ]);
    }

    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->status === ContactMessage::STATUS_NEW) {
            $contactMessage->update([
                'status' => ContactMessage::STATUS_READ,
                'read_at' => now(),
            ]);
            $contactMessage->refresh();
        }

        return view('admin.contact-messages.show', [
            'message' => $contactMessage,
            'statuses' => ContactMessage::statuses(),
        ]);
    }

    public function update(UpdateContactMessageRequest $request, ContactMessage $contactMessage): RedirectResponse
    {
        $data = $request->validated();

        if (($data['status'] ?? null) === ContactMessage::STATUS_READ && $contactMessage->read_at === null) {
            $data['read_at'] = now();
        }

        $contactMessage->update($data);

        return back()->with('status', __('messages.contact_message_updated'));
    }
}
