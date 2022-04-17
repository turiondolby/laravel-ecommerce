@if ($cart->isEmpty())
    <div class="p-6 bg-white border-b border-gray-200">
        Your cart is empty.
    </div>
@else
    <div class="overflow-hidden grid grid-cols-6 grid-flow-col gap-4">
        <div class="p-6 bg-white border-b border-gray-200 col-span-4 -mt-3 self-start">
            @foreach($cart->contents() as $variation)
                <livewire:cart-item :variation="$variation" :key="$variation->id"/>
            @endforeach
        </div>

        <div class="p-6 bg-white border-b border-gray-200 col-span-2 self-start">
            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Subtotal</div>
                        <h1 class="font-semibold text-xl">
                            {{ $cart->formattedSubtotal() }}
                        </h1>
                    </div>
                </div>

                <x-button-anchor href="/checkout">Checkout</x-button-anchor>
            </div>

        </div>
    </div>
@endif
