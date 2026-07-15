<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.email_reply_title') }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111; line-height: 1.6;">
    <p>{{ __('messages.email_reply_hello', ['name' => $contact->name]) }}</p>

    <p>{{ __('messages.email_reply_thanks', ['date' => $contact->created_at->format('d/m/Y')]) }}</p>

    <p><strong>{{ __('messages.email_reply_subject') }}</strong> {{ $contact->subject }}</p>

    <p><strong>{{ __('messages.email_reply_your_message') }}</strong></p>
    <p style="white-space: pre-line;">{{ $contact->message }}</p>

    <hr>

    <p><strong>{{ __('messages.email_reply_our_reply') }}</strong></p>
    <p style="white-space: pre-line;">{!! nl2br(e($reply)) !!}</p>

    <hr>

    <p>{{ __('messages.email_reply_regards') }}</p>
    <p>{{ __('messages.email_reply_team') }}</p>
</body>
</html>
