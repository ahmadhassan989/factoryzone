@php
    $productName = $product?->name ?? __('ui.email.general_inquiry');
@endphp

<p>{{ __('ui.email.hello') }} {{ $factory->contact_name ?? $factory->name }},</p>

<p>{{ __('ui.email.new_inquiry_intro') }}</p>

<p>
    <strong>{{ __('ui.email.product') }}:</strong> {{ $productName }}<br>
    <strong>{{ __('ui.email.buyer_name') }}:</strong> {{ $inquiry->buyer_name ?? __('ui.email.na') }}<br>
    <strong>{{ __('ui.email.buyer_email') }}:</strong> {{ $inquiry->buyer_email ?? __('ui.email.na') }}<br>
    <strong>{{ __('ui.email.buyer_phone') }}:</strong> {{ $inquiry->buyer_phone ?? __('ui.email.na') }}<br>
    <strong>{{ __('ui.email.quantity') }}:</strong> {{ $inquiry->quantity ?? __('ui.email.na') }}<br>
    <strong>{{ __('ui.email.source') }}:</strong> {{ $inquiry->source }}
</p>

@if ($inquiry->message)
    <p>
        <strong>{{ __('ui.email.message') }}:</strong><br>
        {{ $inquiry->message }}
    </p>
@endif

<p>{{ __('ui.email.follow_up') }}</p>
