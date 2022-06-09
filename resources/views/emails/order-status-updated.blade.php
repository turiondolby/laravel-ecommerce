@component('mail::message')
# The status of your order (#{{ $order->id }}) has changed.

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
