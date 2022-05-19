<form>
    <div class="overflow-hidden sm:rounded-lg grid grid-cols-6 grid-flow-col gap-4">
        <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-6">
            <div class="space-y-3">
                <div class="font-semibold text-lg">Account details</div>

                <div>
                    <label for="email">Email</label>
                    <x-input id="email" class="block mt-1 w-full" type="text" name="email"/>

                    <div class="mt-2 font-semibold text-red-500">
                        An error
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Shipping</div>

                <x-select class="w-full">
                    <option value="">Choose a pre-saved address</option>
                    <option value="">Pre-saved address</option>
                </x-select>

                <div class="space-y-3">
                    <div>
                        <label for="address">Address</label>
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address"/>

                        <div class="mt-2 font-semibold text-red-500">
                            An error
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label for="address">City</label>
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address"/>

                            <div class="mt-2 font-semibold text-red-500">
                                An error
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="address">Postal code</label>
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address"/>

                            <div class="mt-2 font-semibold text-red-500">
                                An error
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Delivery</div>

                <div class="space-y-1">
                    <x-select wire:model="shippingTypeId" class="w-full">
                        @foreach($shippingTypes as $shippingType)
                            <option value="{{ $shippingType->id }}">
                                {{ $shippingType->title }} ({{ $shippingType->formattedPrice() }})
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Payment</div>

                <div>
                    Stripe card form
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-4">
            <div>
                @foreach($cart->contents() as $variation)
                    <div class="border-b py-3 flex items-start">
                        <div class="w-16 mr-4">
                            <img src="{{ $variation->getFirstMediaUrl('default', 'thumb200x200') }}" class="w-16">
                        </div>

                        <div class="space-y-2">
                            <div>
                                <div class="font-semibold">
                                    {{ $variation->formattedPrice() }}
                                </div>
                                <div class="space-y-1">
                                    <div>{{ $variation->product->title }}</div>

                                    <div class="flex items-center text-sm">
                                        <div class="mr-1 font-semibold">
                                            Quantity: {{ $variation->pivot->quantity }}
                                            <span class="text-gray-400 mx-1">/</span>
                                        </div>
                                        @foreach($variation->ancestorsAndSelf as $ancestor)
                                            {{ $ancestor->title }}
                                            @if (! $loop->last)
                                                <span class="text-gray-400 mx-1">/</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Subtotal</div>
                        <h1 class="font-semibold">$0</h1>
                    </div>

                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Shipping ({{ $this->shippingType->title }})</div>
                        <h1 class="font-semibold">{{ $this->shippingType->formattedPrice() }}</h1>
                    </div>

                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Total</div>
                        <h1 class="font-semibold">$0</h1>
                    </div>
                </div>

                <x-button type="submit">Confirm order and pay</x-button>
            </div>
        </div>
    </div>
</form>
