<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orders
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg space-y-3">
                @forelse($orders as $order)
                    <div class="bg-white p-6 col-span-4 space-y-3">
                        <div class="border-b pb-3 flex items-center justify-between">
                            <div>#{{ $order->id }}</div>
                            <div>{{ $order->formattedSubtotal() }}</div>
                            <div>{{ $order->shippingType->title }}</div>
                            <div>{{ $order->created_at->toDayDateTimeString() }}</div>

                            <div>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm rounded-full font-semibold bg-gray-100 text-gray-800">
                                @if($order->status() === 'placed_at')
                                    Order placed
                                @elseif($order->status() === 'packaged_at')
                                    Order packaged
                                @elseif($order->status() === 'shipped_at')
                                    Order shipped
                                @endif
                            </span>
                            </div>
                        </div>

                        @foreach($order->variations as $variation)
                            <div class="border-b py-3 space-y-2 flex items-center last:border-0 last:pb-0">
                                <div class="w-16 mr-4">
                                    <img src="{{ $variation->getFirstMediaUrl('default', 'thumb200x200') }}"
                                         class="w-16">
                                </div>

                                <div class="space-y-1">
                                    <div>
                                        <div class="font-semibold">{{ $variation->formattedPrice() }}</div>
                                        <div>{{ $variation->product->title }}</div>
                                    </div>

                                    <div class="flex items-center text-sm">
                                        <div class="mr-1 font-semibold">
                                            Quantity: {{ $variation->pivot->quantity }} <span
                                                class="text-gray-400 mx-1">/</span>
                                        </div>
                                        @foreach($variation->ancestorsAndSelf as $ancestor)
                                            {{ $ancestor->title }} @if(! $loop->last)
                                                <span class="text-gray-400 mx-1">/</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    No orders
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
