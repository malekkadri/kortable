<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreContactMessageRequest;
use App\Mail\NewContactMessageNotification;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(string $locale): View
    {
        $contactPage = Page::published()
            ->where(function ($query) use ($locale) {
                $query->where('slug', 'contact')
                    ->orWhere("slug_translations->{$locale}", 'contact');
            })
            ->first();

        return view('front.contact', [
            'contactPage' => $contactPage,
            'siteSetting' => SiteSetting::first(),
        ]);
    }

    public function store(StoreContactMessageRequest $request, string $locale): RedirectResponse
    {
        $message = ContactMessage::create($request->validatedPayload());

        $recipient = SiteSetting::query()->value('contact_email') ?: config('mail.from.address');

        if ($recipient) {
            Mail::to($recipient)->send(new NewContactMessageNotification($message, $locale));
        }

        return redirect()
            ->route('front.contact.show', ['locale' => $locale])
            ->with('status', __('messages.contact_form_success'));
    }
}
