@component('mail::message')
# Hello {{ $offer->applicant->name }},

Congratulations! Please find your **Offer Letter** attached.

@component('mail::button', ['url' => url('/')])
Visit Our Website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
