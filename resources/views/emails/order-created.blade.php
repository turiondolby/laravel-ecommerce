@component('mail::message')
# Your order (#{{ $order->id }}) has been placed.

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
