<h2>{{ __('messages.contact_notification_heading', [], $locale) }}</h2>
<p><strong>{{ __('ui.name', [], $locale) }}:</strong> {{ $contactMessage->name }}</p>
<p><strong>{{ __('ui.email', [], $locale) }}:</strong> {{ $contactMessage->email }}</p>
@if($contactMessage->phone)
    <p><strong>{{ __('ui.phone', [], $locale) }}:</strong> {{ $contactMessage->phone }}</p>
@endif
<p><strong>{{ __('ui.subject', [], $locale) }}:</strong> {{ $contactMessage->subject }}</p>
<p><strong>{{ __('ui.message', [], $locale) }}:</strong></p>
<p>{{ $contactMessage->message }}</p>
