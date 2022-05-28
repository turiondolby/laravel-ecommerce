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
                              Order status
                            </span>
                            </div>
                        </div>

                        <div class="border-b py-3 space-y-2 flex items-center last:border-0 last:pb-0">
                            <div class="w-16 mr-4">
                                <img src="" class="w-16">
                            </div>

                            <div class="space-y-1">
                                <div>
                                    <div class="font-semibold">Formatted price</div>
                                    <div>Variation product title</div>
                                </div>

                                <div class="flex items-center text-sm">
                                    <div class="mr-1 font-semibold">
                                        Quantity: 0 <span class="text-gray-400 mx-1">/</span>
                                    </div>
                                    Variation title <span class="text-gray-400 mx-1">/</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    No orders
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
